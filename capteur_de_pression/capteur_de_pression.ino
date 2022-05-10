//#include <LiquidCrystal_I2C.h> //inclure la bibliothèque

#include <ESP8266WiFi.h>
#include <PubSubClient.h>

//LiquidCrystal_I2C lcd(0x3F, 20, 4); //définir les caractéristiques de l'écran LCD

void setup()
{
  Serial.begin(112500);
  //lcd.init(); //initialiser l'écran LCD
  //lcd.backlight(); //allumer le rétroéclairage
}
void loop()
{
  int sensorVal=analogRead(A0); //lire la valeur sur le pin A0

  float voltage= (sensorVal*5.0)/1024.0; //convertir le signal analogique 0-5Volt en signal 0-1024

  float pressure_pascal = (3.0*((float)voltage-0.47))*1000000.0; //convertir le signal en une pression pascal
  float pressure_bar = pressure_pascal/10e5; //convertir la pression de pascals à bars

  //lcd.setCursor(0,0);
  Serial.print("Pression="); //ecire le message entre les guillemets

  //lcd.setCursor(5,0);
  Serial.print(pressure_bar*0.83); //écrire la variable entre les parenthèses
  //lcd.print(" bars"); //écrire le message entre les guillemets
  delay(100);
}
