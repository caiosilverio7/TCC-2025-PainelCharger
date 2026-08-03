#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "Tororo";
const char* password = "tororoxd";
const char* serverName = "http://safebike-server.alwaysdata.net/get_led.php";

const int ledPin = 2;
String lastStatus = "";

void setup() {
  Serial.begin(115200);
  pinMode(ledPin, OUTPUT);

  WiFi.begin(ssid, password);
  Serial.print("Conectando ao WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConectado!");
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverName);
    
    // Define o cabeçalho da requisição POST
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Envia o POST com corpo vazio (ou você pode colocar algo como "id=1" se o PHP esperar)
    int httpCode = http.POST(""); 

    if (httpCode == 200) {
      String payload = http.getString();
      payload.trim();

      if (payload != lastStatus) {
        lastStatus = payload;
        if (payload == "on") {
          digitalWrite(ledPin, HIGH);
        } else if (payload == "off") {
          digitalWrite(ledPin, LOW);
        }
        Serial.println("LED: " + payload);
      }
    } else {
      Serial.println("Erro HTTP: " + String(httpCode));
    }
    http.end();
  }
  delay(500);
}
