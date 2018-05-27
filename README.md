# Smart Classroom Air Quality System

Our IoT solution allows users to be in control of air quality in their environments. Users can monitor different parameters about the indoor air quality in real time, or they can view past and (predicted) future values as well by using our web interface. These parameters consist of temperature, humidity, and overall air quality score.

By using machine learning, besides monitoring, our system in the cloud can predict when air quality will drop below optimal levels so that it can send feedback to IoT device by combining real time data and prediction.

## Team Members

* Mert Aközcan
* Emre Bilgili
* Muhammed Emin Güre

## Repository Structure

* **Cloud:** Node-RED flow in JSON format (can be imported to any Node-RED flow)
* **Figures**
   * **cloud:** Screenshots from Node-RED flow and IBM Bluemix platform 
   * **configuration_ui:** Screenshots of WiFi configuration UI which could be seen when setting up the device for the first time
   * **hardware:** Pictures of the device and connection diagram
   * **web_ui:** Screenshots from web UI which includes charts and graphs
* **ML:** Code for generating test data 
* **Node:** ESP8266 NodeMCU Code written on Arduino IDE
* **UI:** Code for user interface

### If you have used an open source code, please give the link only with special thanks to the code owner.

## Hardware setup

### Components
* ESP8266 NodeMCU CP2102 V2
* MQ135 Gas Sensor
* DHT22 Temperature and Humidity Sensor
* Buzzer
* Red and Yellow LEDs
* Jumper Cables

### Diagram

![Breadboard Diagram](/Figures/hardware/breadboard-diagram.png)

## Flow of data
Draw flow of data in your **implementation**. At each node, specify the name of the code that processes the input data and produces the output. Note that the code name, input data name, output name must be consistent with the names at the Code part.

## Development Environment

* **Operating System:** MacOS Sierra 10.13.4
* **Tools**
    * Arduino IDE 1.8.3
    * IBM Bluemix Internet of Things Platform
    * Node-RED v0.18.4
    * Cloudant NoSQL DB Build 6909
    * IBM Watson Studio (for Machine Learning services)

To setup Arduino IDE in order to compile and upload the [code](https://github.com/bounIoT/ClassroomAir/blob/master/Node/classroom_air.ino) into ESP8266 NodeMCU device,

* Add 'http://arduino.esp8266.com/stable/package_esp8266com_index.json' to Preferences -> Additional Boards Manager URLs
* From Sketch -> Include Library -> Manage Libraries find and install
    * Adafruit Circuit Playground by Adafruit v1.2.1
    * Adafruit Unified Sensor by Adafruit v1.0.2
    * DHT Sensor Library by Adafruit v1.3.0
    * PubSubClient by Nick O'Leary v2.6.0
    * WiFiManager by tzapu v0.12.0

Fake data generator [FakeData.py](https://github.com/bounIoT/ClassroomAir/blob/master/ML/FakeData.py) could be run using Python 3.6.4

## References

### PubSubClient

https://github.com/knolleary/pubsubclient

We used PubSubClient for MQTT connection on ESP8266 NodeMCU device.

### WiFiManager

https://github.com/tzapu/WiFiManager

With WiFiManager, we can set up WiFi connection of ESP8266 dynamically instead of hard coding that information into the code.

### ChartJS

https://www.chartjs.org/

We used Chart.js in our web interface to create beautiful charts and graphics to show air quality data.