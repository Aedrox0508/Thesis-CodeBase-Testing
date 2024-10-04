#include <WiFi.h>

// Network credentials
const char* ssid = "ESP32";
const char* password = "password";

WiFiServer server(80);

// Flex Sensor Pins (GPIOs)
const int flexSensorPins[5] = {32, 33, 34, 35, 36};

// Variables to store flex sensor readings
int flexValues[5];

// Default value for flex sensors (not bent)
const int flexDefaultValue = 850;

String flexMessages[5] = {"", "", "", "", ""};
String combinedMessage = "";

void setup() {
  Serial.begin(115200);

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
  // Read the values from the flex sensors
  for (int i = 0; i < 5; i++) {
    flexValues[i] = analogRead(flexSensorPins[i]);
  }

  // Determine the messages based on flex sensor values
  for (int i = 0; i < 5; i++) {
    if (flexValues[i] < flexDefaultValue - 100) {
      switch (i) {
        case 0: flexMessages[i] = "I am okay"; break;
        case 1: flexMessages[i] = "I want water"; break;
        case 2: flexMessages[i] = "I want to eat"; break;
        case 3: flexMessages[i] = "I want to pee"; break;
        case 4: flexMessages[i] = "I want to go to the bathroom"; break;
      }
    } else {
      flexMessages[i] = "";  // No message if not bent
    }
    Serial.println(flexMessages[i]);
  }

  // Print the message to Serial Monitor if any flex sensor is bent
  for (int i = 0; i < 5; i++) {
    if (flexMessages[i] != "") {
      Serial.println(flexMessages[i]);
    }
  }

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
      client.println("<h1>ESP32 Flex Sensor Real-Time Data</h1>");
      client.println("<div id=\"data\">Loading...</div>");
      client.println("</body></html>");

      client.println();
    }

    // Serve the data in plain text, including flex sensor messages
    if (request.indexOf("GET /data") >= 0) {
      String response = "";
      for (int i = 0; i < 5; i++) {
        if (flexMessages[i] != "") {
          response += flexMessages[i] + "<br>";
        }
      }
      client.println(response);
    }

    client.stop();
  }

  delay(500);  // Delay for readability in Serial Monitor
}
