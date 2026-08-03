#include <WiFi.h>
#include <HTTPClient.h>

int rele = 26;

const char* ssid = "PROFESSORES";   //Colocar o usuario do seu WI-FI
const char* password = "Prof#2024"; //Senha do seu Wi-fi

// Trocar pelo IP do seu PC computador da mesma rede que o seu wifi
String serverName = "http://192.168.1.12/3binfo/atualiza.php";
String valorRecebido = "";

void setup() 
{
    Serial.begin(115200);

    pinMode(rele, OUTPUT);
   
    WiFi.begin(ssid, password);
    Serial.print("Conectando ao WiFi");
    while (WiFi.status() != WL_CONNECTED) 
    {
      delay(500);
      Serial.print(".");
    }
    Serial.println("\nConectado!");
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) 
  {
    HTTPClient http;

    http.begin(serverName);
    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) 
    {
      valorRecebido = http.getString();
      valorRecebido.trim();
      
      Serial.print("Resposta do PHP: ");
      Serial.println(valorRecebido);
      
      if (valorRecebido.equals("ativo")) 
      {  
          digitalWrite(rele, HIGH);  //Liga o Rele
      } 
      else 
      {
        digitalWrite(rele, LOW);     //Desliga o Rele
      }

      
    } 
    else 
    {
      Serial.print("Erro HTTP: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else 
  {
    Serial.println("WiFi desconectado!");
  }

  delay(3000); // lê a cada 3 segundos
}
