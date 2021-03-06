#include <SoftwareSerial.h>
#include <PubSubClient.h>

SoftwareSerial BTSerial(0,1);
const int BATTERYPIN = A0; //pin de la batterie

const float TensionMin = 3.5; //tension min
const float TensionMax = 7.5; //tension max


void setup() {
  Serial.begin(115200);
  BTSerial.begin(115200);
}



int getBattery (String message)
{
  
  float b = analogRead(BATTERYPIN); //valeur analogique

  int minValeur = (1023 * TensionMin) / 5; //Arduino
  int maxValeur = (1023 * TensionMax) / 5; //Arduino

  //int minValue = (4095 * TensionMin) / 3; //ESP32
  //int maxValue = (4095 * TensionMax) / 3; //ESP32

  b = ((b - minValeur) / (maxValeur - minValeur)) * 100; //mettre en pourcentage

  


  if (b > 100) //max is 100%
    b = 100;



  else if (b < 0) //min is 0%
    b = 0;
  int valeur = b;
  return b;
}

void loop() {
  
  String message;
  while(Serial.available()){
    message = BTSerial.readString();
    BTSerial.write(Serial.read());
  }
  Serial.println(getBattery(message));
  delay(1000);
}
