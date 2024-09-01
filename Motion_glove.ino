#include <WiFi.h>
#include <Wire.h>
#include <MPU6050.h>

// Network credentials
const char* ssid = "ESP32";
const char* password = "password";

WiFiServer server(80);

MPU6050 mpu;

// Flex Sensor Pins (GPIOs)
const int flexSensorPins[5] = {32, 33, 34, 35, 36};

// Variables to store sensor readings
int16_t ax, ay, az;
int16_t gx, gy, gz;
float angleX, angleY;
int flexValues[5];

// Default value for flex sensors (not bent)
const int flexDefaultValue = 850;

String angleMessage = "";
String flexMessages[5] = {"", "", "", "", ""};
String combinedMessage = "";

void setup() {
  Serial.begin(115200);

  // Initialize I2C communication
  Wire.begin(21, 22);  // SDA, SCL pins
  
  // Initialize MPU6050
  mpu.initialize();
  
  // Check if the MPU6050 is connected
  if (!mpu.testConnection()) {
    Serial.println("MPU6050 connection failed");
    while (1);
  }

  Serial.println("MPU6050 connection successful");

  // Set up Flex Sensor pins as inputs
  for (int i = 0; i < 5; i++) {
    pinMode(flexSensorPins[i], INPUT);
  }

  // Connect to Wi-Fi network
  WiFi.softAP(ssid, password);
  
  // Print IP address and start web server
  Serial.println("");
  Serial.println("IP address: ");
  Serial.println(WiFi.softAPIP());
  server.begin();
}

void loop() {
  // Get accelerometer and gyroscope data from MPU6050
  mpu.getMotion6(&ax, &ay, &az, &gx, &gy, &gz);
  
  // Convert accelerometer data to angles
  angleX = atan2(ay, az) * 180 / PI;
  angleY = atan2(ax, az) * 180 / PI;

  // Read the values from the flex sensors
  for (int i = 0; i < 5; i++) {
    flexValues[i] = analogRead(flexSensorPins[i]);
  }

  // Display MPU6050 angles on Serial Monitor
  Serial.print("Angle X: ");
  Serial.print(angleX);
  Serial.print("\tAngle Y: ");
  Serial.println(angleY);

  // Determine the messages based on flex sensor values
  for (int i = 0; i < 5; i++) {
    if (flexValues[i] < flexDefaultValue - 100) {
      flexMessages[i] = "Flex Sensor " + String(i+1) + " is bent!";
    } else {
      flexMessages[i] = "Flex Sensor " + String(i+1) + " is not bent.";
    }
    Serial.println(flexMessages[i]);
  }

  // Determine angle-based messages
  if (angleX > 40 && angleX < 50) {
    angleMessage = "MPU6050: Angle X is between 40 and 50 degrees!";
  } else if (angleX > 30 && angleX < 40) {
    angleMessage = "MPU6050: Angle X is between 30 and 40 degrees!";
  } else {
    angleMessage = "MPU6050: Angle X is out of range.";
  }
  Serial.println(angleMessage);

  // Determine combined message based on MPU6050 and flex sensor conditions
  if (angleX > 45 && angleX < 50 && flexValues[0] < flexDefaultValue - 100) {
    combinedMessage = "Special condition met: Angle X is between 45 and 50 degrees and Flex Sensor 1 is bent!";
  } else {
    combinedMessage = "No special conditions met.";
  }
  Serial.println(combinedMessage);

  // Web Server Handling
  WiFiClient client = server.available();

  if (client) {
    String request = client.readStringUntil('\r');
    client.flush();

    if (request.indexOf("GET / ") >= 0) {
      client.println("HTTP/1.1 200 OK");
      client.println("Content-type:text/html");
      client.println("Connection: close");
      client.println();

      client.println("<!DOCTYPE html><html>");
      client.println("<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">");
      client.println("<script>");
      client.println("function getData() {");
      client.println("  var xhttp = new XMLHttpRequest();");
      client.println("  xhttp.onreadystatechange = function() {");
      client.println("    if (this.readyState == 4 && this.status == 200) {");
      client.println("      document.getElementById(\"data\").innerHTML = this.responseText;");
      client.println("    }");
      client.println("  };");
      client.println("  xhttp.open(\"GET\", \"/data\", true);");
      client.println("  xhttp.send();");
      client.println("}");
      client.println("setInterval(function() { getData(); }, 1000);");  // Update every 1 second
      client.println("</script>");
      client.println("</head>");
      client.println("<body>");
      client.println("<h1>ESP32 MPU6050 & Flex Sensor Real-Time Data</h1>");
      client.println("<div id=\"data\">Loading...</div>");
      client.println("</body></html>");

      client.println();
    }

    // Serve the data in plain text, including MPU6050 and flex sensor messages
    if (request.indexOf("GET /data") >= 0) {
      String response = angleMessage + "<br>";
      for (int i = 0; i < 5; i++) {
        response += flexMessages[i] + "<br>";
      }
      response += combinedMessage;
      client.println(response);
    }

    client.stop();
  }

  delay(500);  // Delay for readability in Serial Monitor
}
