#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "";  // Replace with your WiFi SSID
const char* password = "";  // Replace with your WiFi password

// Server URL
String serverName = "https://movewave.online/MoveWave_V2/fetch_gesture.php";  // URL for the PHP file

// Flex sensor pins
const int flexPinThumb = 36;
const int flexPinIndex = 35;
const int flexPinMiddle = 34;
const int flexPinRing = 33;
const int flexPinPinky = 32;

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);

  // Wait until the ESP32 is connected to WiFi
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void loop() {
  int thumb_value = analogRead(flexPinThumb);
  int index_value = analogRead(flexPinIndex);
  int middle_value = analogRead(flexPinMiddle);
  int ring_value = analogRead(flexPinRing);
  int pinky_value = analogRead(flexPinPinky);

  // Display the sensor readings

  String gesture_name = "";

  // Determine the gesture name based on which fingers are bent
  // Thumb connected gestures
  if (thumb_value > 250 && thumb_value < 650) {
    // Check for the most complex gestures first (e.g., Thumb, Index, Middle, Ring, Pinky)
    if (thumb_value > 250 && thumb_value < 650 && index_value > 250 && index_value < 600 && middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600 && pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 20";  // All fingers
    } else if (thumb_value > 250 && thumb_value < 650 && middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600) {
      gesture_name = "Com 18";  // Thumb, Middle & Ring
    } else if (index_value > 250 && index_value < 650) {
      gesture_name = "Com 2";  // Thumb & Index
    } else if (middle_value > 250 && middle_value < 650) {
      gesture_name = "Com 3";  // Thumb & Middle
    } else if (ring_value > 250 && ring_value < 650) {
      gesture_name = "Com 4";  // Thumb & Ring
    } else if (pinky_value > 250 && pinky_value < 650) {
      gesture_name = "Com 5";  // Thumb & Pinky
    } else {
      gesture_name = "Com 1";  // Thumb only
    }
  }

  // Index connected gestures
  else if (index_value > 250 && index_value < 600) {
    if (index_value > 250 && index_value < 600 && middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600 && pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 16";  // Index, Middle, Ring & Pinky
    } else if (index_value > 250 && index_value < 600 && middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600) {
      gesture_name = "Com 17";  // Index, Middle & Ring
    } else if (middle_value > 250 && middle_value < 600) {
      gesture_name = "Com 7";  // Index & Middle
    } else if (ring_value > 250 && ring_value < 600) {
      gesture_name = "Com 8";  // Index & Ring
    } else if (pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 9";  // Index & Pinky
    } else {
      gesture_name = "Com 6";  // Index only
    }
  }

  // Middle connected gestures
  else if (middle_value > 250 && middle_value < 600) {
    if (middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600 && pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 19";  // Middle, Ring & Pinky
    } else if (ring_value > 250 && ring_value < 600) {
      gesture_name = "Com 11";  // Middle & Ring
    } else if (pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 12";  // Middle & Pinky
    } else {
      gesture_name = "Com 10";  // Middle only
    }
  }

  // Ring connected gestures
  else if (ring_value > 250 && ring_value < 600) {
    if (pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 14";  // Ring & Pinky
    } else {
      gesture_name = "Com 13";  // Ring only
    }
  }

  // Pinky connected gestures
  else if (pinky_value > 250 && pinky_value < 600) {
    gesture_name = "Com 15";  // Pinky only
  }


  // If a gesture name is determined, send it to the server
  if (gesture_name != "") {
    String postData = "gesture_name=" + gesture_name;
    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      http.begin(serverName);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      // Send the gesture name to the PHP server
      int httpResponseCode = http.POST(postData);

      // Display HTTP response code for debugging
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);

      if (httpResponseCode > 0) {
        String response = http.getString();
        Serial.println("Response from server: " + response);  // Should print the flex_gesture from the database
      } else {
        Serial.println("Error on sending POST");
      }

      http.end();  // Free resources
    } else {
      Serial.println("WiFi not connected");
    }
  }

  delay(3000);  // Wait for 3 seconds before the next reading
}
