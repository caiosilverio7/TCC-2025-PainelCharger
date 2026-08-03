#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "RedeDaNasa";       // Nome do Wi-Fi
const char* password = "Teste123";     // Senha do Wi-Fi

// ⚠️ Troque o IP e o ID do usuário conforme seu caso
String serverName = "http://10.0.0.10/TCC/esp32_status.php?id_usuario=7";

const int relePin = 5; // Pino do relé
String resposta = "";

void setup() {
  Serial.begin(115200);
  pinMode(relePin, OUTPUT);
  digitalWrite(relePin, LOW);

  Serial.println("Conectando ao Wi-Fi...");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWi-Fi conectado!");
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverName);
    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
      resposta = http.getString();
      resposta.trim();

      Serial.print("Status recebido: ");
      Serial.println(resposta);

      if (resposta == "ativo") {
        digitalWrite(relePin, HIGH);
        Serial.println("⚡ Energia LIBERADA");
      } else {
        digitalWrite(relePin, LOW);
        Serial.println("⛔ Energia CORTADA");
      }
    } else {
      Serial.print("Erro HTTP: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("Wi-Fi desconectado!");
  }

  delay(60000); // Verifica a cada 1 minuto
}
