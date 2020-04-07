int xA;
int yA;
int zA;
 
void setup() {
  analogReference(EXTERNAL);
  Serial.begin(9600);
}
 
void loop() {
 
  xA = analogRead(A0);
  yA = analogRead(A1);
  zA = analogRead(A2);
  Serial.print("{\"datox\":"); 
  Serial.print(xA);
  Serial.print(",");
  delay(100);
  Serial.print("\"datoy\":");
  Serial.print(yA);
  Serial.print(",");
  delay(100);
  Serial.print("\"datoz\":");
  Serial.print(zA);
   Serial.print("}\n");
  delay(100);
 
}
