#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <ESP8266WiFi.h>

#include <PubSubClient.h> // MQTT
#include <WiFiManager.h> // WiFi Setup
#include "DHT.h"

// Define DHT pins
#define DHTPIN 14 // D5 on board
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

// Define gas sensor pin
#define GASPIN 17 // A0 on board

// Define LED pins
#define REDPIN 13 // D7 on board
#define YELLOWPIN 12 // D6 on board

// Define buzzer pin
#define BUZZERPIN 4 // D2 on board

// Define period (in ms) for sensor data to be read and sent to cloud
#define PERIOD 10000

// Quantities that are measured
float temperature = 0;
float humidity = 0;
float quality = 0;

// MQTT Configuration
const char* mqtt_server = "iot.eclipse.org";

// Topics that are uniquely created by using chip id
String evt = String("v1/classroomair/" + String(system_get_chip_id()) + "/evt");
const char* evt_topic = evt.c_str();
String fdb = String("v1/classroomair/" + String(system_get_chip_id()) + "/fdb");
const char* fdb_topic = fdb.c_str();

// Create an instance of PubSubClient client for MQTT connection
WiFiClient espClient;
PubSubClient client(espClient);

// Timer to control publish intervals
long lastMsg = 0;

// Message received from a subscribed topic (over MQTT)
char msg[60];

// Store buzzer status
int lastBuzzerStatus = 0;

// Called when a message is received from one of subscribed topics over MQTT.
void receivedCallback(char* topic, byte* payload, unsigned int length) {
  Serial.print("Message received: ");
  Serial.println(topic);
  Serial.print("payload: ");
  for (int i = 0; i < length; i++) {
    Serial.print((char)payload[i]);
  }
  Serial.println();
  
  if ((char)payload[0] == '2') {
    // Severe conditions
    digitalWrite(REDPIN, HIGH);
    digitalWrite(YELLOWPIN, LOW);
    // If buzzer is off, turn it on and set its status to 1
    // in order to avoid continuous buzzer warnings.
    if (lastBuzzerStatus == 0) {
      digitalWrite(BUZZERPIN, HIGH);
      delay(250);
      digitalWrite(BUZZERPIN, LOW);
      delay(250);
      digitalWrite(BUZZERPIN, HIGH);
      delay(250);
      digitalWrite(BUZZERPIN, LOW);
      lastBuzzerStatus = 1;
    }
  } else if ((char)payload[0] == '1') {
    // Tolerable conditions
    digitalWrite(YELLOWPIN, HIGH);
    digitalWrite(REDPIN, LOW);
    lastBuzzerStatus = 0;
  } else {
    // Optimal conditions
    digitalWrite(YELLOWPIN, LOW);
    digitalWrite(REDPIN, LOW);
    lastBuzzerStatus = 0;
  }
}

// Allows MQTT client to connect to MQTT broker(server).
void mqttconnect() {
  // Loop until reconnected
  while (!client.connected()) {
    Serial.print("MQTT connecting ...");
    // MQTT Client ID
    String clientId = "ESP8266_2260669";
    // Connect
    if (client.connect(clientId.c_str())) {
      Serial.println("connected");
      // Subscribe to topic with default QoS 0
      client.subscribe(fdb_topic);
    } else {
      Serial.print("Failed, status code = ");
      Serial.print(client.state());
      Serial.println("Try again in 5 seconds...");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}

void setup() {
  Serial.begin(115200);

  // Put ESP8266 in server mode and allow user to communicate with board
  // over WiFi and select the network of his/her choice to connect
  WiFiManager wifiManager;
  // wifiManager.resetSettings(); // For testing only
  wifiManager.autoConnect("KURULUM");

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  // Set LED and buzzer pins as output
  pinMode(REDPIN, OUTPUT);
  pinMode(YELLOWPIN, OUTPUT);
  pinMode(BUZZERPIN, OUTPUT);
  // Set gas pin as input in order to read sensor data
  pinMode(GASPIN, INPUT);

  // Configure the MQTT server with IPaddress and port
  client.setServer(mqtt_server, 1883);
  // 'receivedCallback' function will be invoked when
  // client receives something from subscribed topic
  client.setCallback(receivedCallback);

  // Start DHT sensor
  dht.begin();
}

void loop() {
  // If client was disconnected then try to reconnect again
  if (!client.connected()) {
    mqttconnect();
  }

  // Listen for incoming messages from subscribed topic
  client.loop();

  // Read data from sensors in a certain period of time
  long now = millis();
  if (now - lastMsg > PERIOD) {
    lastMsg = now;
    // Read data
    temperature = dht.readTemperature();
    humidity = dht.readHumidity();
    quality = analogRead(GASPIN);
    Serial.print("Temperature: ");
    Serial.println(temperature);
    Serial.print("Humidity: ");
    Serial.println(humidity);
    Serial.print("Quality: ");
    Serial.println(quality);
    Serial.println("------");
    if (!isnan(temperature) && !isnan(humidity) && !isnan(quality)) {
      snprintf(msg, 60, "{\"temp\":%lf,\"hum\":%lf,\"quality\":%lf}", temperature, humidity, quality);
      // Publish the message in JSON format
      client.publish(evt_topic, msg);
    }
  }
}
