// client, user and device details
var serverUrl   = "ws://mqtt.cumulocity.com/mqtt";     /* wss://mqtt.cumulocity.com/mqtt for a secure connection */
var clientId    = "DHA-1";
var device_name = "DHA-IP Camera # 1";
var tenant = "t423154829";//"t102634969";
var username = "dani@skais.com.my";//"ska_user";
var password = "c8Y4ska!";

var undeliveredMessages = [];
var temperature = 25;

// configure the client to Cumulocity IoT
var client = new Paho.MQTT.Client(serverUrl, clientId);

// display all incoming messages
client.onMessageArrived = function (message) {
    log('Received operation "' + message.payloadString + '"');
    if (message.payloadString.indexOf("510") == 0) {

        log('Received operation "' + message.payloadString + '"');
        
        publish("s/us", "501,c8y_Restart");
        log("Initiating device restart...");

        setTimeout(function() {
            publish("s/us", "501,c8y_Restart");
            log("Restarting");
        }, 1000);


        var data = new FormData();
        data.append("auth_token", "123456");
        data.append("brand", "dahua");
        data.append("host", "http://192.168.0.108");
        data.append("user", "admin");
        data.append("password", "dha12345");

        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function() {

            if(this.readyState === 4) { 

                //log(this.responseText);
                setTimeout(function() {

                    publish("s/us", "503,c8y_Restart");
                    log("Restart Successfull");

                }, 1000);

                
            }

        });

        xhr.open("POST", "http://localhost/device_management/api_agent/reboot");
        xhr.setRequestHeader("Access-Control-Allow-Origin","*");

        xhr.send(data);
        
        
        
    }
    
    //firmware payload = 515 
    if (message.payloadString.indexOf("515") == 0) {
        
        publish("s/us", "501,c8y_Firmware");
        log('Initiating the upgrade process');
        var data_str  = message.payloadString.split(',');
        var upgrade_url = data_str[4];
        
        publish("s/us", "501,c8y_Firmware");
        log('Firmware File Download started'); 


        var data = new FormData();
        data.append("auth_token", "123456");
        data.append("brand", "dahua");
        data.append("host", "http://192.168.0.108");
        data.append("user", "admin");
        data.append("password", "dha12345");
        data.append("firmware_url", upgrade_url);
        data.append("tenant", tenant);
        data.append("auth", username+':'+password);
        
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function() {
            if(this.readyState === 4) {

                publish("s/us", "503,c8y_Firmware");
                log('FirmWare Updated  Successfully'); 
                //log('API response =>'+Uploadthis.responseText);
                //get_upgrade_state();

            }else{

                log("Please Wait!.");
            }
        });

        xhr.open("POST", "http://localhost/device_management/api_agent/update_firmware_from_url");
        xhr.setRequestHeader("Access-Control-Allow-Origin","*");

        xhr.send(data); 
        
        
    }

     //software payload = 515 
    if (message.payloadString.indexOf("516") == 0) {

        publish("s/us", "501,c8y_SoftwareList");
        log('Initiating the software installation process');
        var data_str  = message.payloadString.split(',');
        var software_url = data_str[4];

        publish("s/us", "501,c8y_SoftwareList");
        log('Software File Download started'); 


        var data = new FormData();
        data.append("auth_token", "123456");
        data.append("brand", "dahua");
        data.append("host", "http://192.168.0.108");
        data.append("user", "admin");
        data.append("password", "dha12345");
        data.append("software_url", software_url);
        data.append("tenant", tenant);
        data.append("auth", username+':'+password);
        
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function() {
            if(this.readyState === 4) {

                publish("s/us", "503,c8y_SoftwareList");
                log('Software installed  Successfully'); 
                log('API response =>'+this.responseText);
                //get_upgrade_state();

            }else{

                log("Please Wait!.");
            }
        });

        xhr.open("POST", "http://localhost/device_management/api_agent/installapp");
        xhr.setRequestHeader("Access-Control-Allow-Origin","*");

        xhr.send(data); 

       
        
        
    }

    if (message.payloadString.indexOf("511") == 0) {

        var data_str  = message.payloadString.split(',');
        var opt = data_str[2].replace('"','');
        if( opt == 'remove'  || opt == 'Remove' || opt == 'REMOVE'){

            var appName = data_str[3].replace('"','');
        
            publish("s/us", "501,c8y_Command");

            log('Software uninstall process starting'); 


            var data = new FormData();
            data.append("auth_token", "123456");
            data.append("brand", "dahua");
            data.append("host", "http://192.168.0.108");
            data.append("user", "admin");
            data.append("password", "dha12345");
            data.append("appName", appName);
            
            var xhr = new XMLHttpRequest();
            xhr.withCredentials = true;

            xhr.addEventListener("readystatechange", function() {
                if(this.readyState === 4) {

                    publish("s/us", "503,c8y_Command");
                    log('Software uninstalled  Successfully'); 
                    log('API response =>'+this.responseText);
                    //get_upgrade_state();

                }else{

                    log("Please Wait!.");
                }
            });

            xhr.open("POST", "http://localhost/device_management/api_agent/uninstallapp");
            xhr.setRequestHeader("Access-Control-Allow-Origin","*");

            xhr.send(data); 
        }

        if( opt == 'start' || opt == 'stop'){

            var appName = data_str[3].replace('"','');
        
            publish("s/us", "501,c8y_Command");

            log('Software '+opt+' process started'); 


            var data = new FormData();
            data.append("auth_token", "123456");
            data.append("brand", "dahua");
            data.append("host", "http://192.168.0.108");
            data.append("user", "admin");
            data.append("password", "dha12345");
            data.append("appName", appName);
            data.append("action", opt);
            
            var xhr = new XMLHttpRequest();
            xhr.withCredentials = true;

            xhr.addEventListener("readystatechange", function() {
                if(this.readyState === 4) {

                    publish("s/us", "503,c8y_Command");
                    log('Software '+opt+'  Successfully'); 
                    log('API response =>'+this.responseText);
                    //get_upgrade_state();

                }else{

                    log("Please Wait!.");
                }
            });

            xhr.open("POST", "http://localhost/device_management/api_agent/start_stop_app");
            xhr.setRequestHeader("Access-Control-Allow-Origin","*");

            xhr.send(data); 
        }


    }

};

function get_upgrade_state(){

    var data = new FormData();
        data.append("auth_token", "123456");
        data.append("brand", "dahua");
        data.append("host", "http://192.168.0.108");
        data.append("user", "admin");
        data.append("password", "dha12345");
        
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function() {
            log('Upgrade State =>'+this.responseText);
        });

        xhr.open("POST", "http://localhost/device_management/api_agent/get_upgrade_state");
        xhr.setRequestHeader("Access-Control-Allow-Origin","*");

        xhr.send(data); 


}

// display all delivered messages
client.onMessageDelivered = function onMessageDelivered (message) {
    log('Message "' + message.payloadString + '" delivered');
    var undeliveredMessage = undeliveredMessages.pop();
    if (undeliveredMessage.onMessageDeliveredCallback) {
        undeliveredMessage.onMessageDeliveredCallback();
    }
};

function createDevice() {

    // register a new device
    publish("s/us", "100," + device_name + ",SDC Camera", function() {

        // set hardware information
        publish("s/us", "110,6F0E801PAG41728,DH-IPC-HFW7442HP-ZFR,2.800.0000000.5.R", function() {

            publish('s/us', '114,c8y_Availability,c8y_Connection', function() {});

            publish('s/us', '114,c8y_UnavailabilityAlarm,c8y_ActiveAlarmsStatus', function() {});

            // set hardware information
            publish("s/us", '113,"auth_token=123456\nbrand=dahua\nhost=http://192.168.0.108\nuser=admin\npassword=dha12345"', function() {


                // set hardware operations
                publish('s/us', '114,c8y_Restart,c8y_Firmware,c8y_SoftwareList,c8y_Configuration,c8y_Command,c8y_SupportedOperations', function() {
                    
                    //publish("s/us", '116,DhopDemo,1.0,https://ska.cumulocity.com/inventory/binaries/27108');
                    
                    
                    //checking device status
                    var data = new FormData();
                    data.append("auth_token", "123456");
                    data.append("brand", "dahua");
                    data.append("host", "http://192.168.0.108");
                    data.append("user", "admin");
                    data.append("password", "dha12345");

                    var xhr = new XMLHttpRequest();
                    xhr.withCredentials = true;

                    xhr.addEventListener("readystatechange", function() {

                        if(this.readyState === 4) { 

                            if(this.responseText == '1'){
                                log('Status : Connected');
                                publish('s/us', '400,c8y_Check_Connection,"Connected status returned "', function() {
                                        });
                                // publish("s/us", "501,c8y_Check_Connection");
                                // publish("s/us", "503,c8y_Check_Connection");
                            }else{
                                log('Status : Disconnected');
                            }
                            return this.responseText;

                            
                        }

                    });

                    xhr.open("POST", "http://localhost/device_management/api_agent/get_time");
                    xhr.setRequestHeader("Access-Control-Allow-Origin","*");

                    xhr.send(data);

                    setInterval(function() {
                        
                        
                        //checking device statusa
                        var data = new FormData();
                        data.append("auth_token", "123456");
                        data.append("brand", "dahua");
                        data.append("host", "http://192.168.0.108");
                        data.append("user", "admin");
                        data.append("password", "dha12345");

                        var xhr = new XMLHttpRequest();
                        xhr.withCredentials = true;

                        xhr.addEventListener("readystatechange", function() {

                            if(this.readyState === 4) { 

                                if(this.responseText == '1'){
                                    log('Status : Connected');
                                    publish('s/us', '400,c8y_Check_Connection,"Connected status returned "', function() {
                                            });
                                    publish("s/us", "501,c8y_Connection");
                                    publish("s/us", "503,c8y_Connection");
                                }else{
                                    log('Status : Disconnected');
                                }
                                return this.responseText;

                                
                            }

                        });

                        xhr.open("POST", "http://localhost/device_management/api_agent/get_time");
                        xhr.setRequestHeader("Access-Control-Allow-Origin","*");

                        xhr.send(data);

                    }, 60000);
                    

                    //listen for operation
                    client.subscribe("s/ds");
                });
                
            });
        });
    });
}


// send a message
function publish (topic, message, onMessageDeliveredCallback) {
    message = new Paho.MQTT.Message(message);
    message.destinationName = topic;
    message.qos = 2;
    undeliveredMessages.push({
        message: message,
        onMessageDeliveredCallback: onMessageDeliveredCallback
    });
    client.send(message);
}

// connect the client to Cumulocity IoT
function init() {
    //alert('Initializing...');
    client.connect({
        userName: tenant + "/" + username,
        password: password,
        onSuccess: createDevice
    });
}

// display all messages on the page
function log (message) {
    document.getElementById('logger').insertAdjacentHTML('beforeend', '<div class="log_msg">' + message + '</div>');
}

// function notification (){

//     $ curl -X POST \
//     -H "Authorization: Bearer ABCDEFGH" \
//     -H "Content-Type: application/json" \
//     -d '{"payload": "Test message from HA", "topic": "home/notification"}' \
//     http://IP_ADDRESS:8123/api/services/mqtt/publish
// }




init();