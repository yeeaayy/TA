#include <WiFi.h>
#include <PubSubClient.h>
#include <PZEM004Tv30.h>


const char* ssid = "";            // Ganti dengan nama WiFi Anda
const char* password = "";        // Ganti dengan password WiFi Anda
const char* mqtt_server = "";     // Ganti dengan alamat broker MQTT Anda
const char* mqtt_username = "";   // Ganti dengan username yang sudah di buat  
const char* mqtt_password = "";   // Ganti dengan password yang sudah di buat
const char* mqtt_topic = "";      // Ganti dengan topic yang sudah dibuat
const int mqtt_port = 1883;

WiFiClient espClient;
PubSubClient client(espClient);

// Konfigurasi PZEM
#define RX_PIN 16 // Pin RX pada ESP32
#define TX_PIN 17 // Pin TX pada ESP32
PZEM004Tv30 pzem(RX_PIN, TX_PIN);

void setup() {
  Serial.begin(115200); // Inisialisasi Serial
  setupWiFi();          // Koneksi ke WiFi
  client.setServer(mqtt_server, mqtt_port); // Set broker MQTT
}

void loop() {
  // Pastikan koneksi MQTT tetap terjaga
  if (!client.connected()) {
    reconnectMQTT();
  }
  client.loop();

  // Membaca data dari PZEM
  float voltage = pzem.voltage();
  float current = pzem.current();
  float power = pzem.power();

  // Format data ke JSON
  String jsonPayload = "{";
  jsonPayload += "\"voltage\": " + String(voltage, 2) + ",";
  jsonPayload += "\"current\": " + String(current, 2) + ",";
  jsonPayload += "\"power\": " + String(power, 2) + ",";
  jsonPayload += "}";

  // Kirim data ke broker MQTT
  client.publish(mqtt_topic, jsonPayload.c_str());
  Serial.println("Data published: " + jsonPayload);

  delay(2000); // Delay sebelum pembacaan berikutnya
}

void setupWiFi() {
  delay(10);
  Serial.println("Connecting to WiFi...");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi connected!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
}

void reconnectMQTT() {
  while (!client.connected()) {
    Serial.println("Attempting MQTT connection...");
    // Client ID unik
    String clientId = "ESP32Client-" + String(random(0xffff), HEX);
    if (client.connect(clientId.c_str())) {
      Serial.println("Connected to MQTT broker!");
    } else {
      Serial.print("Failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds...");
      delay(5000);
    }
  }
}
