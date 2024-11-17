#include <WiFi.h>
#include <WiFiClientSecure.h>
#include <HTTPClient.h>
#include <WiFiManager.h> // Include the WiFiManager library
#include <UniversalTelegramBot.h>

// Server URL
String serverName = "https://movewave.online/MoveWave_V2/fetch_gesture.php";

// Telegram Bot credentials
String telegramBotToken = "8127084337:AAH_1xCbf8U3DCUkfP8HBk3wXwgFAabuFw0"; // Replace with your Telegram bot token
String telegramChatId = "6755870128"; // Replace with your Telegram chat ID

WiFiClientSecure client;
UniversalTelegramBot bot(telegramBotToken, client);

// Flex sensor pins
const int flexPinThumb = 36;
const int flexPinIndex = 35;
const int flexPinMiddle = 34;
const int flexPinRing = 33;
const int flexPinPinky = 32;

// Gesture variables
String lastGesture = "";

// Send gesture data to the server
void sendToServer(String gesture_name) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    String postData = "gesture_name=" + gesture_name;

    http.begin(serverName);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int httpResponseCode = http.POST(postData);
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server response: " + response);
      bot.sendMessage(telegramChatId, "Server Response: " + response, "");
    } else {
      Serial.println("Error sending POST request");
    }
    http.end();
  } else {
    Serial.println("WiFi not connected");
  }
}

// Detect and process gestures
String detectGesture() {
  int thumb_value = analogRead(flexPinThumb);
  int index_value = analogRead(flexPinIndex);
  int middle_value = analogRead(flexPinMiddle);
  int ring_value = analogRead(flexPinRing);
  int pinky_value = analogRead(flexPinPinky);

  String gesture_name = "";

  if (thumb_value > 250 && thumb_value < 650) {
    if (thumb_value > 250 && thumb_value < 650 && index_value > 250 && index_value < 600 && 
        middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600 && 
        pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 20";  // All fingers
    } else if (middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600) {
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
  } else if (index_value > 250 && index_value < 600) {
    if (middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600 && 
        pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 16";  // Index, Middle, Ring & Pinky
    } else if (middle_value > 250 && middle_value < 600 && ring_value > 250 && ring_value < 600) {
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
  } else if (middle_value > 250 && middle_value < 600) {
    if (ring_value > 250 && ring_value < 600 && pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 19";  // Middle, Ring & Pinky
    } else if (ring_value > 250 && ring_value < 600) {
      gesture_name = "Com 11";  // Middle & Ring
    } else if (pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 12";  // Middle & Pinky
    } else {
      gesture_name = "Com 10";  // Middle only
    }
  } else if (ring_value > 250 && ring_value < 600) {
    if (pinky_value > 250 && pinky_value < 600) {
      gesture_name = "Com 14";  // Ring & Pinky
    } else {
      gesture_name = "Com 13";  // Ring only
    }
  } else if (pinky_value > 250 && pinky_value < 600) {
    gesture_name = "Com 15";  // Pinky only
  }

  return gesture_name;
}

// Setup function
void setup() {
  Serial.begin(115200);

  // Initialize WiFiManager
  WiFiManager wifiManager;
  wifiManager.autoConnect("ESP32-Glove"); // AutoConnect with fallback web portal

  Serial.println("Connected to WiFi!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  // Initialize Telegram Bot
  client.setCACert(TELEGRAM_CERTIFICATE_ROOT); // Secure connection for Telegram
  bot.sendMessage(telegramChatId, "ESP32 Connected", "");

  // Pin modes
  pinMode(flexPinThumb, INPUT);
  pinMode(flexPinIndex, INPUT);
  pinMode(flexPinMiddle, INPUT);
  pinMode(flexPinRing, INPUT);
  pinMode(flexPinPinky, INPUT);
}

// Loop function
void loop() {
  String detectedGesture = detectGesture();

  if (detectedGesture != "" && detectedGesture != lastGesture) {
    lastGesture = detectedGesture;

    // Notify Telegram and send data to the server
    bot.sendMessage(telegramChatId, "Gesture Detected: " + detectedGesture, "");
    sendToServer(detectedGesture);
  }

  delay(3500); // Adjust delay as needed
}
