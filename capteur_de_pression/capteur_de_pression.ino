#include <ESP8266WiFi.h>
#include <PubSubClient.h>

/*const char* ssid = "CCF_Montgolfiere";
const char* password = "";

const char* mqtt_server = "192.168.107.136";


WiFiClient espClient;
PubSubClient client(espClient);
long now = millis();
long lastMeasure = 0;

void setup_wifi() {
  delay(10);
  // We start by connecting to a WiFi network
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("WiFi connected - ESP IP address: ");
  Serial.println(WiFi.localIP());
}


void callback(String topic, byte* message, unsigned int length) {
  Serial.print("Message arrived on topic: ");
  Serial.print(topic);
  Serial.print(". Message: ");
  String messageTemp;

  for (int i = 0; i < length; i++) {
    Serial.print((char)message[i]);
    messageTemp += (char)message[i];
  }
  Serial.println();
}


void reconnect() {
  // Loop until we're reconnected
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    if (client.connect("ESP8266Client", "usersnir2", "projetmontgolfiere")) {
      Serial.println("connected");
      // Subscribe or resubscribe to a topic
      // You can subscribe to more topics (to control more LEDs in this example)

    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}

*/

void setup()
{
  //lcd.init(); //initialiser l'écran LCD
  //lcd.backlight(); //allumer le rétroéclairage
  Serial.begin(112500);
  /*setup_wifi();
  client.setServer(mqtt_server, 1883);
  client.setCallback(callback);
*/
}


void loop()
{

  int sensorVal=analogRead(A0); //lire la valeur sur le pin A0

    /*if (!client.connected()) {
    reconnect();
  }
  if (!client.loop())
    client.connect("ESP8266Client");

  now = millis();
  // Publishes new temperature and humidity every 30 seconds
  if (now - lastMeasure > 30000) {
    lastMeasure = now;

*/

  float voltage= (sensorVal*5.0)/1024.0; //convertir le signal analogique 0-5Volt en signal 0-1024

  float pressure_pascal = (3.0*((float)voltage-0.47))*1000000.0; //convertir le signal en une pression pascal
  float pressure_bar = pressure_pascal/10e5; //convertir la pression de pascals à bars

  //lcd.setCursor(0,0);
  Serial.print("Pression="); //ecire le message entre les guillemets

  //lcd.setCursor(5,0);
  Serial.print(pressure_bar*0.83); //écrire la variable entre les parenthèses
  //lcd.print(" bars"); //écrire le message entre les guillemets
  delay(1000);
}
