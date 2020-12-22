// MQTT dependency https://github.com/mqttjs/MQTT.js
const mqtt = require("mqtt");
var axios = require('axios');
var FormData = require('form-data');
var session_id = "session_id";
var fs = require('fs');


start_script();

function start_script() {

    var devices = get_group_devices();
    devices.then(rest => {

        if (rest.length > 0) {
        	if (data_obj.c8y_Hardware !== undefined) {

        		mqtt_connect_client(data_obj.c8y_Hardware.serialNumber);

        	}else{

        		mqtt_connect_client(rest[0].name);
        	}
            
        } else {
            console.log("No devices found");
            start_script();
        }
    });
}

function mqtt_connect_client(clientId) {

    // client, user and device details
    const serverUrl = "tcp://mqtt.cumulocity.com";
    var device_name = clientId;
    const tenant = "t423154829";
    const username = "dani@skais.com.my";
    const password = "c8Y4ska!";
    const api_url = "http://localhost/device_management/api_agent/";

    // connect the client to Cumulocity
    const client = mqtt.connect(serverUrl, {
        username: tenant + "/" + username,
        password: password,
        clientId: clientId
    });

    // once connected...
    client.on("connect", function() {
        // ...register a new device with restart operation
        client.publish("s/us", "100," + device_name + ",c8y_Serial", function() {
            // set hardware operations
            client.publish('s/us', '114,c8y_Restart,c8y_Firmware,c8y_Software,c8y_SoftwareList,c8y_Configuration,c8y_Command,c8y_Connection,c8y_Availability');
            client.subscribe("s/ds");
            var device_auth_token = '123456';
            var device_brand = 'dahua';
            var device_host = "";
            var device_user = "";
            var device_pass = "";



            var device_data = get_devices_data(clientId);
            device_data.then(device_obj => {

                if (device_obj.length > 0) {
                    var data_obj = device_obj['0'];

                    if (data_obj.c8y_Configuration !== undefined) {

                        devconfig = data_obj.c8y_Configuration.config;
                        var config_arr1 = devconfig.split(',');
                        device_host = "http://" + config_arr1['0'].split('=')['1'];
                        device_user = config_arr1['1'].split('=')['1'];
                        device_pass = config_arr1['2'].split('=')['1'];

                        let buff = Buffer.from(device_pass, 'base64');
                        device_pass = buff.toString('ascii');

                        //checking firmware api
                        var firmware_api = generic_api(api_url, "get_firmware_version", device_auth_token, device_brand, device_host, device_user, device_pass)
                        firmware_api.then(firmware_rest => {

                            if (firmware_rest !== '' && firmware_rest !== undefined && firmware_rest !== 0) {
                                console.log("Parent =>" + firmware_rest);
                                var softversion = firmware_rest.split(',')[0].split('=')['1'];
                                client.publish("s/us", "115,," + softversion + ",");
                            }

                        });

                        var hardware_api = generic_api(api_url, "get_device_model", device_auth_token, device_brand, device_host, device_user, device_pass)
                        hardware_api.then(hardware_rest => {
                            if (hardware_rest !== '' && hardware_rest !== undefined && hardware_rest !== 0) {

                                console.log("Parent =>" + hardware_rest);
                                var model = hardware_rest.split('=')['1'];
                                client.publish("s/us", "110," + clientId + "," + model + ",");
                            }

                        });

                        

                        var camera_app = get_camera_apps(device_host);
                        camera_app.then(app_rest => {
                            console.log('Apps From Camera');
                            if (app_rest.params !== undefined) {

                                if (app_rest.params.ListInfo !== undefined) {

                                    var app_ListInfo = app_rest.params.ListInfo;

                                    var ListInfo_string = "";
                                    for (var i = app_ListInfo.length - 1; i >= 0; i--) {
                                        var AppName = app_ListInfo[i].AppName;
                                        var Version = app_ListInfo[i].Version;
                                        var App_status = app_ListInfo[i].RunState;
                                        var App_url = '';
                                        app_ListInfo[i].name = app_ListInfo[i].AppName;
                                        app_ListInfo[i].version = app_ListInfo[i].Version;


                                        ListInfo_string += "" + AppName + "," + Version + "," + App_url;
                                        if (i > 0) {
                                            ListInfo_string += ",";
                                        }

                                    }
                                    console.log(app_ListInfo);
                                    var dataJSON = {
                                        "c8y_SoftwareList": app_ListInfo
                                    };
                                    console.log(dataJSON);
                                    console.log(ListInfo_string);
                                    client.publish("s/us/" + clientId, "116," + ListInfo_string + "");
                                    update_device(data_obj.id, JSON.stringify(dataJSON));

                                }

                            }

                        });


                        var conection_api = generic_api(api_url, "get_time", device_auth_token, device_brand, device_host, device_user, device_pass)
                        conection_api.then(conection_rest => {

                            if (conection_rest === 1) {

                                client.publish('s/us', '400,c8y_Check_Connection,"Connected status returned "', function() {});

                                client.publish("s/us", "503,c8y_Connection");
                                client.publish("s/us", "503,c8y_Check_Connection");
                                console.log(" Parent Connected");
                                var dataJSON = JSON.stringify({
                                    "device_status": "Connected"
                                });
                                update_device(data_obj.id, dataJSON);
                            } else {
                                if (conection_rest === 'invalidauth') {

                                    var dataJSON = JSON.stringify({
                                        "device_status": "Invalid username or password"
                                    });
                                    update_device(data_obj.id, dataJSON);
                                    console.log(' Parent Invalid username or password');

                                } else {

                                    var dataJSON = JSON.stringify({
                                        "device_status": "Disconnected"
                                    });
                                    update_device(data_obj.id, dataJSON);
                                    console.log(' Parent Disconnected');

                                }

                            }

                        });



                        if (data_obj.childDevices !== "undefined") {

                            var references = data_obj.childDevices.references;
                            var child_id = "";
                            var child_data = "";
                            for (var index = references.length - 1; index >= 0; index--) {

                            	if (references[index].managedObject.c8y_Hardware !== undefined) {

					        		child_id = references[index].managedObject.c8y_Hardware.serialNumber;

					        	}else{

					        		child_id = references[index].managedObject.name;
					        	}
                                

                                child_data = get_devices_data(child_id);
                                child_data.then(child_obj => {

                                    var child_data_obj = child_obj['0'];

                                    if (child_data_obj.c8y_Configuration !== undefined) {

                                        var devconfig = child_data_obj.c8y_Configuration.config;
                                        var config_arr1 = devconfig.split(',');
                                        var child_device_host = "http://" + config_arr1['0'].split('=')['1'];
                                        var child_device_user = config_arr1['1'].split('=')['1'];
                                        var child_device_pass = config_arr1['2'].split('=')['1'];
                                        let buff = Buffer.from(child_device_pass, 'base64');
                                        child_device_pass = buff.toString('ascii');

                                        //checking childfirmware_api
				                        var firmware_api = generic_api(api_url, "get_firmware_version", device_auth_token, device_brand, child_device_host, child_device_user, child_device_pass)
				                        firmware_api.then(firmware_rest => {

				                            if (firmware_rest !== '' && firmware_rest !== undefined && firmware_rest !== 0) {
				                                console.log(child_id+" firmware =>" + firmware_rest);
				                                var softversion = firmware_rest.split(',')[0].split('=')['1'];
				                                client.publish("s/us/"+child_id, "115,," + softversion + ",");
				                            }

				                        });

				                        //checking childhardware_api
				                        var hardware_api = generic_api(api_url, "get_device_model", device_auth_token, device_brand, child_device_host, child_device_user, child_device_pass)
				                        hardware_api.then(hardware_rest => {
				                            if (hardware_rest !== '' && hardware_rest !== undefined && hardware_rest !== 0) {

				                                console.log(child_id+" hardware =>" + hardware_rest);
				                                var model = hardware_rest.split('=')['1'];
				                                client.publish("s/us/"+child_id, "110," + clientId + "," + model + ",");
				                            }

				                        });

				                        var camera_app = get_camera_apps(child_device_host);
				                        camera_app.then(app_rest => {
				                            console.log('Apps From Camera');
				                            if (app_rest.params !== undefined) {

				                                if (app_rest.params.ListInfo !== undefined) {

				                                    var app_ListInfo = app_rest.params.ListInfo;

				                                    var ListInfo_string = "";
				                                    for (var i = app_ListInfo.length - 1; i >= 0; i--) {
				                                        var AppName = app_ListInfo[i].AppName;
				                                        var Version = app_ListInfo[i].Version;
				                                        var App_status = app_ListInfo[i].RunState;
				                                        var App_url = '';
				                                        app_ListInfo[i].name = app_ListInfo[i].AppName;
				                                        app_ListInfo[i].version = app_ListInfo[i].Version;


				                                        ListInfo_string += "" + AppName + "," + Version + "," + App_url;
				                                        if (i > 0) {
				                                            ListInfo_string += ",";
				                                        }

				                                    }
				                                    console.log(app_ListInfo);
				                                    var dataJSON = {
				                                        "c8y_SoftwareList": app_ListInfo
				                                    };
				                                    console.log(dataJSON);
				                                    console.log(ListInfo_string);
				                                    client.publish("s/us/" + clientId, "116," + ListInfo_string + "");
				                                    update_device(data_obj.id, JSON.stringify(dataJSON));

				                                }

				                            }

				                        });

				                        var conection_api = generic_api(api_url, "get_time", device_auth_token, device_brand, child_device_host, child_device_user, child_device_pass)
				                        conection_api.then(conection_rest => {

				                            if (conection_rest === 1) {

				                                client.publish('s/us'+child_id, '400,c8y_Check_Connection,"Connected status returned "', function() {});

				                                client.publish("s/us"+child_id, "503,c8y_Connection");
				                                client.publish("s/us"+child_id, "503,c8y_Check_Connection");
				                                console.log(child_id+" Connected");
				                                var dataJSON = JSON.stringify({
				                                    "device_status": "Connected"
				                                });
				                                update_device(child_data_obj.id, dataJSON);
				                            } else {
				                                if (conection_rest === 'invalidauth') {

				                                    var dataJSON = JSON.stringify({
				                                        "device_status": "Invalid username or password"
				                                    });
				                                    update_device(child_data_obj.id, dataJSON);
				                                    console.log(' Parent Invalid username or password');

				                                } else {

				                                    var dataJSON = JSON.stringify({
				                                        "device_status": "Disconnected"
				                                    });
				                                    update_device(child_data_obj.id, dataJSON);
				                                    console.log(' Parent Disconnected');

				                                }

				                            }

				                        });

                                    }

                                });

                            }

                        }


                    }

                } else {
                    start_script();
                }


            });
				
            var interval = setInterval(function() {

                var device_data = get_devices_data(clientId);
	            device_data.then(device_obj => {

	                if (device_obj.length > 0) {
	                    var data_obj = device_obj['0'];

	                    if (data_obj.c8y_Configuration !== undefined) {

	                        devconfig = data_obj.c8y_Configuration.config;
	                        var config_arr1 = devconfig.split(',');
	                        device_host = "http://" + config_arr1['0'].split('=')['1'];
	                        device_user = config_arr1['1'].split('=')['1'];
	                        device_pass = config_arr1['2'].split('=')['1'];

	                        let buff = Buffer.from(device_pass, 'base64');
	                        device_pass = buff.toString('ascii');

	                        //checking firmware api
	                        var firmware_api = generic_api(api_url, "get_firmware_version", device_auth_token, device_brand, device_host, device_user, device_pass)
	                        firmware_api.then(firmware_rest => {

	                            if (firmware_rest !== '' && firmware_rest !== undefined && firmware_rest !== 0) {
	                                console.log("Parent =>" + firmware_rest);
	                                var softversion = firmware_rest.split(',')[0].split('=')['1'];
	                                client.publish("s/us", "115,," + softversion + ",");
	                            }

	                        });

	                        var hardware_api = generic_api(api_url, "get_device_model", device_auth_token, device_brand, device_host, device_user, device_pass)
	                        hardware_api.then(hardware_rest => {
	                            if (hardware_rest !== '' && hardware_rest !== undefined && hardware_rest !== 0) {

	                                console.log("Parent =>" + hardware_rest);
	                                var model = hardware_rest.split('=')['1'];
	                                client.publish("s/us", "110," + clientId + "," + model + ",");
	                            }

	                        });



	                        var conection_api = generic_api(api_url, "get_time", device_auth_token, device_brand, device_host, device_user, device_pass)
	                        conection_api.then(conection_rest => {

	                            if (conection_rest === 1) {

	                                client.publish('s/us', '400,c8y_Check_Connection,"Connected status returned "', function() {});

	                                client.publish("s/us", "503,c8y_Connection");
	                                client.publish("s/us", "503,c8y_Check_Connection");
	                                console.log(" Parent Connected");
	                                var dataJSON = JSON.stringify({
	                                    "device_status": "Connected"
	                                });
	                                update_device(data_obj.id, dataJSON);
	                            } else {
	                                if (conection_rest === 'invalidauth') {

	                                    var dataJSON = JSON.stringify({
	                                        "device_status": "Invalid username or password"
	                                    });
	                                    update_device(data_obj.id, dataJSON);
	                                    console.log(' Parent Invalid username or password');

	                                } else {

	                                    var dataJSON = JSON.stringify({
	                                        "device_status": "Disconnected"
	                                    });
	                                    update_device(data_obj.id, dataJSON);
	                                    console.log(' Parent Disconnected');

	                                }

	                            }

	                        });



	                        if (data_obj.childDevices !== "undefined") {

	                            var references = data_obj.childDevices.references;
	                            var child_id = "";
	                            var child_data = "";
	                            for (var index = references.length - 1; index >= 0; index--) {

	                            	if (references[index].managedObject.c8y_Hardware !== undefined) {

						        		child_id = references[index].managedObject.c8y_Hardware.serialNumber;

						        	}else{

						        		child_id = references[index].managedObject.name;
						        	}
	                                

	                                child_data = get_devices_data(child_id);
	                                child_data.then(child_obj => {

	                                    var child_data_obj = child_obj['0'];

	                                    if (child_data_obj.c8y_Configuration !== undefined) {

	                                        var devconfig = child_data_obj.c8y_Configuration.config;
	                                        var config_arr1 = devconfig.split(',');
	                                        var child_device_host = "http://" + config_arr1['0'].split('=')['1'];
	                                        var child_device_user = config_arr1['1'].split('=')['1'];
	                                        var child_device_pass = config_arr1['2'].split('=')['1'];
	                                        let buff = Buffer.from(child_device_pass, 'base64');
	                                        child_device_pass = buff.toString('ascii');

	                                        //checking childfirmware_api
					                        var firmware_api = generic_api(api_url, "get_firmware_version", device_auth_token, device_brand, child_device_host, child_device_user, child_device_pass)
					                        firmware_api.then(firmware_rest => {

					                            if (firmware_rest !== '' && firmware_rest !== undefined && firmware_rest !== 0) {
					                                console.log(child_id+" firmware =>" + firmware_rest);
					                                var softversion = firmware_rest.split(',')[0].split('=')['1'];
					                                client.publish("s/us/"+child_id, "115,," + softversion + ",");
					                            }

					                        });

					                        //checking childhardware_api
					                        var hardware_api = generic_api(api_url, "get_device_model", device_auth_token, device_brand, child_device_host, child_device_user, child_device_pass)
					                        hardware_api.then(hardware_rest => {
					                            if (hardware_rest !== '' && hardware_rest !== undefined && hardware_rest !== 0) {

					                                console.log(child_id+" hardware =>" + hardware_rest);
					                                var model = hardware_rest.split('=')['1'];
					                                client.publish("s/us/"+child_id, "110," + clientId + "," + model + ",");
					                            }

					                        });


					                        var conection_api = generic_api(api_url, "get_time", device_auth_token, device_brand, child_device_host, child_device_user, child_device_pass)
					                        conection_api.then(conection_rest => {

					                            if (conection_rest === 1) {

					                                client.publish('s/us'+child_id, '400,c8y_Check_Connection,"Connected status returned "', function() {});

					                                client.publish("s/us"+child_id, "503,c8y_Connection");
					                                client.publish("s/us"+child_id, "503,c8y_Check_Connection");
					                                console.log(child_id+" Connected");
					                                var dataJSON = JSON.stringify({
					                                    "device_status": "Connected"
					                                });
					                                update_device(child_data_obj.id, dataJSON);
					                            } else {
					                                if (conection_rest === 'invalidauth') {

					                                    var dataJSON = JSON.stringify({
					                                        "device_status": "Invalid username or password"
					                                    });
					                                    update_device(child_data_obj.id, dataJSON);
					                                    console.log(' Parent Invalid username or password');

					                                } else {

					                                    var dataJSON = JSON.stringify({
					                                        "device_status": "Disconnected"
					                                    });
					                                    update_device(child_data_obj.id, dataJSON);
					                                    console.log(' Parent Disconnected');

					                                }

					                            }

					                        });

	                                    }

	                                });

	                            }

	                        }


	                    }

	                } else {
	                	clearInterval(interval);
	                    start_script();
	                }


	            });

            }, 50000);




        });

    });



    // display all incoming messages
    client.on("message", function(topic, message) {
        console.log('Received operation "' + message + '"');
        var data_str = message.toString().split(',');
        var externalId = data_str[1];

        // geting device data of device that sent operation.
        var device_data = get_devices_data(externalId);
        device_data.then(device_obj => {

            var data_obj = device_obj['0'];
            console.log("Received operation from device" + data_obj.id);

            var device_auth_token = '123456';
            var device_brand = 'dahua';
            var device_host = "";
            var device_user = "";
            var device_pass = "";


            var c8y_SoftwareList = "";

            if (data_obj.c8y_SoftwareList !== undefined) {

                c8y_SoftwareList = data_obj.c8y_SoftwareList;

            }

            if (data_obj.c8y_Configuration !== undefined) {

                devconfig = data_obj.c8y_Configuration.config;
                var config_arr1 = devconfig.split(',');
                device_host = "http://" + config_arr1['0'].split('=')['1'];
                device_user = config_arr1['1'].split('=')['1'];
                device_pass = config_arr1['2'].split('=')['1'].toString('ascii');
                let buff = Buffer.from(device_pass, 'base64');
                device_pass = buff.toString('ascii');

            }


            //restart payload = 510 
            if (message.toString().indexOf("510") == 0) {
               client.publish("s/us"+externalId, "501,c8y_Restart");
                var data = new FormData();
                data.append("auth_token", device_auth_token);
                data.append("brand", device_brand);
                data.append("host", device_host);
                data.append("user", device_user);
                data.append("password", device_pass);

                var config = {
                    method: 'post',
                    url: api_url + "reboot",
                    headers: {
                        ...data.getHeaders()
                    },
                    data: data
                };
                axios(config)
                    .then(function(response) {
                        if (response.data === '1' || response.data === 1) {

                            var dconct_status = 0;
                            var conct_status = 0;
                            var interval122 = setInterval(function() {

                                var conection_api = generic_api(api_url, "get_time", device_auth_token, device_brand, device_host, device_user, device_pass)
                                conection_api.then(conection_rest => {

                                    if (conection_rest !== '' && conection_rest) {

                                        if (dconct_status === 1) {

                                            clearInterval(interval122);
                                           client.publish("s/us"+externalId, "503,c8y_Restart");

                                        }

                                    } else {

                                        dconct_status = 1;
                                        conct_status = 0;
                                    }
                                });
                            }, 5000);
                        } else {
                           client.publish("s/us"+externalId, "502,c8y_Restart");
                            console.log(response.data);
                        }
                    })
                    .catch(function(error) {
                        //console.log(error);
                        console.log('error restarting');
                       client.publish("s/us"+externalId, "502,c8y_Restart");
                    });

            }

            //firmware payload = 515 
            else if (message.toString().indexOf("515") == 0) {

               client.publish("s/us"+externalId, "501,c8y_Firmware");
                console.log('Initiating the upgrade process');
                var data_str = message.toString().split(',');
                var upgrade_url = data_str[4];

               client.publish("s/us"+externalId, "501,c8y_Firmware");
                console.log('Firmware File Download started');


                var data = new FormData();
                data.append("auth_token", device_auth_token);
                data.append("brand", device_brand);
                data.append("host", device_host);
                data.append("user", device_user);
                data.append("password", device_pass);
                data.append("firmware_url", upgrade_url);
                data.append("tenant", tenant);
                data.append("auth", username + ':' + password);

                var config = {
                    method: 'post',
                    url: api_url + "update_firmware_from_url",
                    headers: {
                        ...data.getHeaders()
                    },
                    data: data
                };
                axios(config)
                    .then(function(response) {
                        if (response.data === '1' || response.data === 1) {

                            var dconct_status = 0;
                            var conct_status = 0;
                            var softversion_before = '';
                            var firmware_api = generic_api(api_url, "get_firmware_version", device_auth_token, device_brand, device_host, device_user, device_pass)
                            firmware_api.then(firmware_rest => {
                                if (firmware_rest !== '' && firmware_rest !== undefined && firmware_rest !== 0) {
                                    console.log("checkingversion");
                                    softversion_before = firmware_rest.split(',')[0].split('=')['1'];
                                }

                            });
                            var interval12 = setInterval(function() {

                                var conection_api = generic_api(api_url, "get_time", device_auth_token, device_brand, device_host, device_user, device_pass)
                                conection_api.then(conection_rest => {

                                    if (conection_rest !== '' && conection_rest) {

                                        if (dconct_status === 1) {

                                            clearInterval(interval12);
                                            var firmware_api = generic_api(api_url, "get_firmware_version", device_auth_token, device_brand, device_host, device_user, device_pass)
                                            firmware_api.then(firmware_rest => {
                                                if (firmware_rest !== '' && firmware_rest !== undefined && firmware_rest !== 0) {
                                                    console.log("Parent =>" + firmware_rest);
                                                    var softversion = firmware_rest.split(',')[0].split('=')['1'];
                                                    console.log(softversion_before);
                                                    console.log(softversion);
                                                    if (softversion_before !== softversion) {

                                                       client.publish("s/us"+externalId, "503,c8y_Firmware");
                                                        console.log("Firmware update Successfull");

                                                    } else {
                                                       client.publish("s/us"+externalId, "502,c8y_Firmware");
                                                        console.log("Firmware update unsuccessfull");
                                                    }
                                                }

                                            });
                                        }

                                    } else {

                                        dconct_status = 1;
                                        conct_status = 0;


                                    }




                                });
                            }, 5000);
                        } else {
                           client.publish("s/us"+externalId, "502,c8y_Firmware");
                            console.log(response.data);
                        }
                    })
                    .catch(function(error) {
                        //console.log(error);
                        console.log('error firmware');
                       client.publish("s/us"+externalId, "502,c8y_Firmware");
                    });



            }

            //software payload = 515 
            else if (message.toString().indexOf("516") == 0) {

                client.publish("s/us"+externalId, "501,c8y_SoftwareList");
                console.log('Initiating the software installation process');
                var data_str = message.toString().split(',');

                var software_name = data_str[2];
                var software_vervion = data_str[3];
                var software_url = data_str[4];
                console.log(data_str);

                client.publish("s/us"+externalId, "501,c8y_SoftwareList");
                console.log('Software File Download started');


                var data = new FormData();
                data.append("auth_token", device_auth_token);
                data.append("brand", device_brand);
                data.append("host", device_host);
                data.append("user", device_user);
                data.append("password", device_pass);
                data.append("software_url", software_url);
                data.append("tenant", tenant);
                data.append("auth", username + ':' + password);

                var config = {
                    method: 'post',
                    url: api_url + "installapp",
                    headers: {
                        ...data.getHeaders()
                    },
                    data: data
                };
                axios(config)
                    .then(function(response) {

                        if (response.data === '1' || response.data === 1) {
                            console.log(response.data);
                            console.log("Software install Successfull");
                            var software_string = "";

                            var software_arr = c8y_SoftwareList;

                            if (software_arr !== "" || software_arr !== "undefined") {

                                for (var i = software_arr.length - 1; i >= 0; i--) {

                                    if (software_arr[i].name !== software_name) {

                                        software_string += "" + software_arr[i].name + "," + software_arr[i].version + "," + software_arr[i].url + ",";
                                    }
                                }
                            }
                            software_arr.push({
                                "name": software_name,
                                "version": software_vervion,
                                "url": software_url,
                                "RunState": "stop",
                            });

                            var dataJSON = {
                                "c8y_SoftwareList": software_arr
                            };
                            console.log(dataJSON);
                            update_device(data_obj.id, JSON.stringify(dataJSON));

                            client.publish("s/us"+externalId, "503,c8y_SoftwareList");
                        } else {
                            client.publish("s/us"+externalId, "502,c8y_SoftwareList");
                            console.log(response.data);
                        }




                    })
                    .catch(function(error) {
                        //console.log(error);
                        console.log('error software install');
                        client.publish("s/us"+externalId, "502,c8y_SoftwareList");
                    });




            }

            //shell/command payload = 511
            else if (message.toString().indexOf("511") == 0) {

                var data_str = message.toString().split(',');
                var opt = data_str[2].replace('"', '');
                if (opt == 'remove' || opt == 'Remove' || opt == 'REMOVE') {

                    var appName = data_str[3].replace('"', '');

                    client.publish("s/us"+externalId, "501,c8y_Command");

                    console.log('Software uninstall process starting');


                    var data = new FormData();
                    data.append("auth_token", device_auth_token);
                    data.append("brand", device_brand);
                    data.append("host", device_host);
                    data.append("user", device_user);
                    data.append("password", device_pass);
                    data.append("appName", appName);

                    var config = {
                        method: 'post',
                        url: api_url + "uninstallapp",
                        headers: {
                            ...data.getHeaders()
                        },
                        data: data
                    };
                    axios(config)
                        .then(function(response) {
                            if (response.data === '1' || response.data === 1) {
                                var software_arr = c8y_SoftwareList;
                                var software_arr2 = [];
                                var software_string = "";
                                if (software_arr !== "" || software_arr !== "undefined") {

                                    for (var i = software_arr.length - 1; i >= 0; i--) {

                                        if (appName !== software_arr[i].name) {
                                            software_arr2.push({
                                                "name": software_arr[i].name,
                                                "version": software_arr[i].version,
                                                "url": software_arr[i].url,
                                                "RunState": software_arr[i].RunState
                                            });
                                        }
                                    }
                                }



                                var dataJSON = {
                                    "c8y_SoftwareList": software_arr2
                                };
                                console.log(dataJSON);
                                update_device(data_obj.id, JSON.stringify(dataJSON));

                                client.publish("s/us"+externalId, "503,c8y_Command");
                                console.log('Software uninstalled  Successfully');
                                console.log('API response =>' + response.data);
                            } else {
                                client.publish("s/us"+externalId, "502,c8y_Command");
                            }

                        })
                        .catch(function(error) {
                            //console.log(error);
                            console.log('error');
                            client.publish("s/us"+externalId, "502,c8y_Command");
                        });

                }

                if (opt == 'start' || opt == 'stop') {

                    var appName = data_str[3].replace('"', '');

                    client.publish("s/us"+externalId, "501,c8y_Command");

                    console.log('Software ' + opt + ' process started');


                    var data = new FormData();
                    data.append("auth_token", device_auth_token);
                    data.append("brand", device_brand);
                    data.append("host", device_host);
                    data.append("user", device_user);
                    data.append("password", device_pass);
                    data.append("appName", appName);
                    data.append("action", opt);

                    var config = {
                        method: 'post',
                        url: api_url + "start_stop_app",
                        headers: {
                            ...data.getHeaders()
                        },
                        data: data
                    };
                    axios(config)
                        .then(function(response) {
                            if (response.data === 1 || response.data === '1') {

                                setTimeout(function() {

                                    var software_arr = c8y_SoftwareList;
                                    var software_string = "";
                                    if (software_arr !== "" || software_arr !== "undefined") {

                                        for (var i = software_arr.length - 1; i >= 0; i--) {

                                            if (appName == software_arr[i].name) {
                                                if (opt == 'start') {
                                                    software_arr[i].RunState = 'running';
                                                } else {
                                                    software_arr[i].RunState = 'stop';
                                                }
                                            }
                                        }
                                    }



                                    var dataJSON = {
                                        "c8y_SoftwareList": software_arr
                                    };
                                    console.log(dataJSON);
                                    update_device(data_obj.id, JSON.stringify(dataJSON));
                                    client.publish("s/us"+externalId, "503,c8y_Command");
                                    console.log('API response =>' + response.data);

                                }, 1000);
                            } else {
                                client.publish("s/us"+externalId, "502,c8y_Command");
                                console.log('API response =>' + response.data);
                            }

                        })
                        .catch(function(error) {
                            //console.log(error);
                            client.publish("s/us"+externalId, "502,c8y_Command");
                        });
                }


            }

        });
    });



}

function update_device(device_id, dataJSON) {

    var data = dataJSON;

    var config = {
        method: 'put',
        url: 'https://ska.cumulocity.com/inventory/managedObjects/' + device_id,
        headers: {
            'Authorization': 'Basic ZGFuaUBza2Fpcy5jb20ubXk6YzhZNHNrYSE=',
            'Content-Type': 'application/json'
        },
        data: data
    };

    axios(config)
        .then(function(response) {
            console.log("Device Status updated");
        })
        .catch(function(error) {
            console.log('error');
        });

}

function send_empt_put_request(device_id) {

    var data = JSON.stringify({});

    var config = {
        method: 'put',
        url: 'https://ska.cumulocity.com/inventory/managedObjects/' + device_id,
        headers: {
            'Authorization': 'Basic ZGFuaUBza2Fpcy5jb20ubXk6YzhZNHNrYSE=',
            'Content-Type': 'application/json'
        },
        data: data
    };

    axios(config)
        .then(function(response) {
            console.log("Empty update msg sent to the device");
        })
        .catch(function(error) {
            console.log('error');
        });
}

function get_tenant_groups() {
    return new Promise((resolve) => {
        try {
            var config = {
                method: 'get',
                url: 'https://ska.cumulocity.com/inventory/managedObjects?currentPage=1&withTotalPages=true&pageSize=20&query=$filter=((type eq \'c8y_DeviceGroup\') or (type eq \'c8y_DynamicGroup\'))$orderby=name&skipChildrenNames=true',

                headers: {
                    'Authorization': 'Basic ZGFuaUBza2Fpcy5jb20ubXk6YzhZNHNrYSE='
                }
            };
            axios(config)
                .then(response => {
                    if (response.status == 200) {
                        if (response.data != '') {

                            var result_data = [];
                            var data_obj = response.data.managedObjects;
                            for (var i = data_obj.length - 1; i >= 0; i--) {
                                result_data.push({
                                    "id": data_obj[i].id,
                                    "name": data_obj[i].name
                                });
                            }
                            resolve(result_data);
                        } else {
                            resolve(1);
                        }
                    } else {
                        resolve(1);
                    }

                });
        } catch (error) {
            resolve(error);
        }
    });
}

function get_group_devices(group_id) {
    return new Promise((resolve) => {
        try {
            var config = {
                method: 'get',
                //url: 'https://ska.cumulocity.com/inventory/managedObjects?fragmentType=c8y_IsDevice&pageSize=10&skipChildrenNames=true&withTotalPages=true',
                //url: 'https://ska.cumulocity.com/inventory/managedObjects?pageSize=100&q=&withGroups=true&withTotalPages=true',
                url: "https://ska.cumulocity.com/inventory/managedObjects?currentPage=1&withTotalPages=true&pageSize=20&query=$filter=(((type eq 'c8y_Device') or (type eq 'c8y_Serial')) and (isparent eq 'yes') )&skipChildrenNames=false",
                headers: {
                    'Authorization': 'Basic ZGFuaUBza2Fpcy5jb20ubXk6YzhZNHNrYSE='
                }
            };
            axios(config)
                .then(response => {
                    if (response.status == 200) {
                        if (response.data != '') {

                            var result_data = [];
                            var devid = "";
                            var devname = "";
                            var devexternal = "";
                            var devconfig = "";
                            var c8y_SoftwareList = "";
                            if (response.data["managedObjects"] !== undefined) {
                                var data_obj = response.data.managedObjects;
                                for (var i = data_obj.length - 1; i >= 0; i--) {

                                    devid = "";
                                    devname = "";
                                    devexternal = "";
                                    devconfig = "";
                                    if (data_obj[i].id !== undefined) {

                                        devid = data_obj[i].id;

                                    }
                                    if (data_obj[i].name !== undefined) {

                                        devname = data_obj[i].name;

                                    }
                                    if (data_obj[i].c8y_Hardware !== undefined) {

                                        devexternal = data_obj[i].c8y_Hardware.serialNumber;

                                    }

                                    if (data_obj[i].c8y_SoftwareList !== undefined) {

                                        c8y_SoftwareList = data_obj[i].c8y_SoftwareList;

                                    }

                                    if (data_obj[i].c8y_Configuration !== undefined) {

                                        devconfig = data_obj[i].c8y_Configuration.config;

                                    }
                                    result_data.push({
                                        "id": devid,
                                        "name": devname,
                                        "externalId": devexternal,
                                        "configuration": devconfig,
                                        "c8y_SoftwareList": c8y_SoftwareList
                                    });
                                }
                                resolve(result_data);
                            }
                        } else {
                            resolve(0);
                        }
                    } else {
                        resolve(0);
                    }

                });
        } catch (error) {
            resolve(0);
        }
    });
}

function get_devices_data(device_id) {
    return new Promise((resolve) => {
        try {
            var config = {
                method: 'get',
                url: "https://ska.cumulocity.com/inventory/managedObjects?pageSize=100&q=$filter=(c8y_Hardware.serialNumber eq '" + device_id + "')&withGroups=true&withTotalPages=true",
                headers: {
                    'Authorization': 'Basic ZGFuaUBza2Fpcy5jb20ubXk6YzhZNHNrYSE='
                }
            };
            axios(config)
                .then(response => {
                    if (response.status == 200) {
                        if (response.data != '') {
                            resolve(response.data.managedObjects);
                        } else {
                            resolve(0);
                        }
                    } else {
                        resolve(0);
                    }

                });
        } catch (error) {
            resolve(0);
        }
    });
}

function generic_api(api_url, actions, device_auth_token, device_brand, device_host, device_user, device_pass) {
    return new Promise((resolve) => {
        try {

            //checking device status
            var data = new FormData();
            data.append("auth_token", device_auth_token);
            data.append("brand", device_brand);
            data.append("host", device_host);
            data.append("user", device_user);
            data.append("password", device_pass);



            var config = {
                method: 'post',
                url: api_url + "" + actions,
                headers: {
                    ...data.getHeaders()
                },
                data: data
            };
            axios(config)
                .then(response => {
                    if (response.status == 200) {
                        console.log(actions + '  => ' + response.data);
                        resolve(response.data)
                    } else {
                        resolve(0);
                    }

                });
        } catch (error) {
            resolve(error);
        }
    });
}

function get_camera_apps(ipadd) {

	var camip = ipadd.replace("http://","");
    
    var camera_session = get_session_arr(camip);
    camera_session.then(ses_rest=>{   
        return new Promise((resolve) => {
            try {

                var Session_id = ses_rest.trim();
                console.log("session <" + Session_id + ">");
                var data = JSON.stringify({
                    "method": "installManager.getInstallProcInfo",
                    "params": null,
                    "id": 1159,
                    "session": Session_id
                });

                var config = {
                    method: 'post',
                    url: ipadd + '/RPC2',
                    headers: {
                        'Content-Type': 'application/json',
                        'Cookie': 'secure'
                    },
                    data: data
                };

                axios(config)
                    .then(function(response) {
                        console.log(response.data);
                        resolve(response.data);
                    })
                    .catch(function(error) {
                        resolve(0);
                    });
            } catch (error) {
                resolve(0);
            }
        });
    });

}

function get_session_arr(camip){

    return new Promise((resolve) => {
        var filecontents = "";
        var session_arr = [];
        var cam_session = 'notfound';
        //checking device status
        try {
            filecontents = fs.readFileSync('session_config.txt', 'utf8');
            filecontents = filecontents.replace(/(\r\n|\n|\r)/gm, "");
            filecontents = filecontents.trim();
            console.log(filecontents);

            session_arr = filecontents.split(',');

            for (var i = session_arr.length - 1; i >= 0; i--) {
                session_arr[i] = session_arr[i].split('-');
                if(session_arr[i][0] === camip){
                    cam_session = session_arr[i][1];
                }
            }
            resolve(cam_session);

        } catch (e) {
            console.log('Error:', e.stack);

        }
    });

}