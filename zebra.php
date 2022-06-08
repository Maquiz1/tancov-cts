<!DOCTYPE html>
<html lang="en">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<head>
    <script type="text/javascript" src="js/BrowserPrint-3.0.216.min.js"></script>
    <script type="text/javascript">
        var selected_device;
        var devices = [];
        function setup()
        {
            //Get the default device from the application as a first step. Discovery takes longer to complete.
            BrowserPrint.getDefaultDevice("printer", function(device)
            {

                //Add device to list of devices and to html select element
                selected_device = device;
                devices.push(device);
                var html_select = document.getElementById("selected_device");
                var option = document.createElement("option");
                option.text = device.name;
                html_select.add(option);

                //Discover any other devices available to the application
                BrowserPrint.getLocalDevices(function(device_list){
                    for(var i = 0; i < device_list.length; i++)
                    {
                        //Add device to list of devices and to html select element
                        var device = device_list[i];
                        if(!selected_device || device.uid != selected_device.uid)
                        {
                            devices.push(device);
                            var option = document.createElement("option");
                            option.text = device.name;
                            option.value = device.uid;
                            html_select.add(option);
                        }
                    }

                }, function(){alert("Error getting local devices")},"printer");

            }, function(error){
                alert(error);
            })
        }

        function writeToSelectedPrinter()
        {

            var x=1;var y='';var f=0;var id=document.getElementById('study_id').value;
            var code=document.getElementById('code').value;
            var no=Number(document.getElementById('no_label').value);

            while (f<2){
                var dataToWrite ='^XA^BY1.8,2,70^FO130,50^BC^FD'+id+'^FS^XZ'
                selected_device.send(dataToWrite, undefined, errorCallback);
                f++;
            }

            while(x < no+1){
                if(x < 10){y='0'+x}else{y=x}
                // var dataToWrite ='^XA^BY1.5,2,70^FO102,50^BC^FD'+id+'-'+y+'^FS^XZ'
                var dataToWrite = code;

                selected_device.send(dataToWrite, undefined, errorCallback);
                x++;
            }

        }

        var readCallback = function(readData) {
            if(readData === undefined || readData === null || readData === "")
            {
                alert("No Response from Device");
            }
            else
            {
                alert(readData);
            }

        }
        var errorCallback = function(errorMessage){
            alert("Error: " + errorMessage);
        }

        window.onload = setup;

    </script>
</head>
<body >
<span style="padding-right:50px; font-size:200%">Zebra Browser Print</span><br/>

Selected Device: <select id="selected_device" onchange=onDeviceSelected(this);></select> <!--  <input type="button" value="Change" onclick="changeDevice();">--> <br/><br/>
<p>&nbsp;</p>
<label for="fname">Number of Labels : </label>
<input type="number" name="no_label" id="no_label"><br><br>
<label for="fname">Study/Screening ID : </label>
<input type="text" name="study_id" id="study_id"><br><br>
<label for="fname">CODES : </label>
<textarea id="code" name="code" rows="6"></textarea>
<button id="myButton">Print Barcode</button>
<script>
    var button = document.querySelector('#myButton');
    button.addEventListener('click', function() { writeToSelectedPrinter()});
    button.click();
</script>

</body>
</html>

