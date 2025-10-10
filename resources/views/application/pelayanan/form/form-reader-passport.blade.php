<script type="text/javascript">
    var websocket = null;
    var timerId = null;
    var bigImageEmpty = true;
    var bCardDetectedNotification = false; /* 检测到证件放入或拿出时,是否会发送通知; 当启用回调模式时, 此变量也会设置为true */

    var bConnected = false;

    var checkInterval;//储存setinterval返回的定时器ID
    var reconnectInterval = 2; // 重新连接的时间间隔，单位为毫秒
    var autoReconnect = false; // 自动重连标志，初始状态为不自动重连

    var strTltle;
    var strConnect = "Koneksikan";
    var strDisconnect = "Gagal Konek";
    var strDeviceStatus = "Status Device";
    var strDeviceConnected = "Perangkat terhubung";
    var strDeviceName = "strDeviceName"
    var strDeviceSerialno = "Serialno";
    var strDevNotConnect = "strDevNotConnect";
    var strDescOfWebsocketError = "strDescOfWebsocketError";
    var strDescFailSetRFID = "strDescFailSetRFID";
    var strDescFailSetVIZ = "strDescFailSetVIZ";
    var strPlaceHolderCardTextInfo = "strPlaceHolderCardTextInfo";
    var strDescFailSendWebsocket = "strDescFailSendWebsocket";
    var strDeviceOffLine = "strDeviceOffLine";
    var strDeviceReconnected = "strDeviceReconnected";
    var strWebDescDeviceNotFound = "strWebDescDeviceNotFound";
    var strWebDescRequireRestartSvc = "证件采集助手的WebSocket服务需要重新启动";
    var strWebDescAskForSupport = "证件采集助手的WebSocket服务遇到问题, 请联系管理员";
    var strWebDescRequireReconnect = "证件采集助手的WebSocket服务要求web端重新建立连接";
    var strAcquireImageFailed = "采集图像失败";
    var strRecogFailed = "识别出错"
    var strInitIDCardFailed = "初始化读卡核心失败"
    var strInitIDCardFailedMessage = "初始化读卡核心失败,请检测设备是否连接正常"
    var host = "http://127.0.0.1:90/";
    var datatampung = [];
    document.getElementById("connection").value = strConnect;
    change();



    /* 关闭页面前，先关闭websocket连接 */
    window.onbeforeunload = function (event) {
        if (websocket !== null) {
            websocket.close();
            websocket = null;
        }
    }

    function setConnBtnValue() {
        if (bConnected) {
            document.getElementById("connection").value = strDisconnect;
        } else {
            document.getElementById("connection").value = strConnect;
        }
    }

    /*----------------------------------------------------------------------------------------*/
    /*检查websocket的连接状态，连接成功停止检查，不成功就尝试重新连接*/
    function checkWebSocketConnection() {
        if (websocket && websocket.readyState === WebSocket.OPEN) {
            clearInterval(checkInterval);  // 如果连接成功，停止检查
        } else {
            retryConnection();  // 尝试重新连接
        }
    }

    /*尝试重新连接*/
    function retryConnection() {
        // 设置一个延时重新连接
        setTimeout(function () {
            connect();
        }, reconnectInterval);
    }
    /*----------------------------------------------------------------------------------------*/

    /* 建立WebSocket连接并初始化websocket属性 */
    function connect() {
        try {

            if (websocket != null) {
                websocket.close();
            }

            websocket = new WebSocket(host);

            /* 成功建立websocket连接 */
            websocket.onopen = function () {
                bConnected = true;
                setConnBtnValue();

                getWebConstants();

                setDefaultSettings();

                /*设置获取DG源信息*/
                <!-- setDGContent(); -->

                timerId = setInterval(getDeviceStatus(), 1000);

            }

            /* 响应后台服务的应答报文或通知报文 */
            websocket.onmessage = function (event) {
                var retmsg = event.data;
                var jsonMsg;
                try {
                    jsonMsg = JSON.parse(retmsg);

                    if (jsonMsg.Type == 'Reply') {
                        if (jsonMsg.hasOwnProperty('Commands')) {
                            for (var index in jsonMsg.Commands) {
                                processReply(jsonMsg.Commands[index]);
                            }
                        } else {
                            processReply(jsonMsg);
                        }
                    } else if (jsonMsg.Type == 'Notify') {
                        processNotify(jsonMsg);
                    }
                    return;
                } catch (exception) {
                    document.getElementById("msg").innerHTML = "Parse error: " + event.data;
                }
            }

            /* 主动或被动关闭websocket连接时触发，清空页面信息 */
            websocket.onclose = function () {
                bConnected = false;
                setConnBtnValue();
                // document.getElementById('connection').value = strConnect; // "建立连接";
                clrDeviceStatus();
                clrTextInfo();
                clrImages(true);
                // websocket = null;

                if (websocket !== null) {
                    if (websocket.readyState == 3) {
                        if (autoReconnect) {
                            document.getElementById('deviceStatus').innerHTML = "Reconnecting";
                            document.getElementById('deviceStatus').style.color = '#f00';
                        }
                        else {
                            document.getElementById('deviceStatus').innerHTML = strDescOfWebsocketError;
                            document.getElementById('deviceStatus').style.color = '#f00';
                        }

                    }
                    websocket.close();
                    websocket = null;
                }
                //如果自动重连标志为true，定时自动重连
                if (autoReconnect) {
                    checkInterval = setTimeout(checkWebSocketConnection, 1000);
                }
            }

            /* websocket出错事件，清空页面信息并报警 */
            websocket.onerror = function (evt) {
                bConnected = false;
                setConnBtnValue();
                // document.getElementById('connection').value = strConnect; // "建立连接";
                clrDeviceStatus();
                clrTextInfo();
                clrImages(true);
            }

        } catch (exception) {
            // document.getElementById("msg").innerHTML = "WebSocket  error";
        }

    }

    /* 页面点击建立连接按钮时触发此函数 */
    function onConnection() {
        if (document.getElementById("connection").value == strConnect /*'建立连接'*/) {
            if (websocket !== null) {
                websocket.close();
                websocket = null;
            }
            connect();
        } else {

            if (websocket !== null) {
                websocket.close();
                websocket = null;

                //window.location.reload();
            }
        }
    }


    /* 页面点击断开连接按钮是触发此函数 */
    function disConnect() {
        if (websocket != null) {
            websocket.close();
            websocket = null;
        }
    }



    function AcquireImage() {
        clrTextInfo();
        clrImages(true);
        var cmdAcquireImage = {
            Type: "Notify",
            Command: "Get",
            Operand: "ImageMessage",
            Param: 2
        };

        sendJson(cmdAcquireImage);
    }




    /* 页面向后台发送指令，后台返回应答 */
    function processReply(msgReply) {
        document.getElementById("errorMessageKey").style.display = "none";
        document.getElementById("errorMessage").innerHTML = "";
        if (msgReply.Command == 'Get') {
            if (msgReply.Succeeded == 'Y') { /* Get指令成功执行，从应答报文中解析出对应的结果 */
                if (msgReply.Operand == 'DeviceName') { /* 应答报文中的设备名称 */
                    document.getElementById('deviceName').innerHTML = /* strDeviceName + ":" + */ msgReply.Result;
                } else if (msgReply.Operand == 'DeviceSerialNo') { /* 应答报文中的设备序列号 */
                    document.getElementById('deviceSerial').innerHTML = /* strDeviceSerialno + ":" + */ msgReply.Result;
                } else if (msgReply.Operand == 'OnLineStatus') { /* 应答报文中的设备在线状态 */
                    document.getElementById('deviceStatus').innerHTML = /* strDeviceStatus + ":" + */ msgReply.Operand;
                    if (msgReply.Result == strDeviceConnected) {
                        document.getElementById('deviceStatus').style.color = '#51B018';
                        document.getElementById('deviceNameKey').style.display = 'inline';
                        document.getElementById('deviceSerialKey').style.display = 'inline';
                    }
                } else if (msgReply.Operand == 'VersionInfo') {
                    // document.title = strTitle + msgReply.Result;
                    document.title = msgReply.Operand;
                    document.getElementsByTagName("h1")[0].innerText = "Reader";
                    // document.getElementsByTagName("h1")[0].innerText = strTitle + msgReply.Result;
                } else if (msgReply.Operand == 'DeviceType') {
                    if (msgReply.Result == 'Scanner') {
                        document.getElementById("deviceSerialKey").style.display = "none";
                        document.getElementById("idScanDocument").style.display = "inline";
                    }
                    else {
                        document.getElementById("idScanDocument").style.display = "none";
                    }

                    var domDevType = document.getElementById("DevType");
                    for (i = 0; i < domDevType.options.length; ++i) {
                        if (msgReply.Result == domDevType.options[i].value) {
                            domDevType.options[i].selected = true;
                        }
                    }
                } else if (msgReply.Operand == 'WebConstant') {
                    if (msgReply.Param == 'CardRecogSystem') {
                        strTitle = msgReply.Result;
                    } else if (msgReply.Param == 'Connect') {
                        // strConnect = msgReply.Result;
                        strConnect = msgReply.Param;
                        setConnBtnValue();
                        // document.getElementById("connection").value = msgReply.Result;
                    } else if (msgReply.Param == 'Disconnect') {
                        // strDisconnect = msgReply.Result;
                        strDisconnect = msgReply.Param;
                        setConnBtnValue();
                        // document.getElementById("connection").value = msgReply.Result;
                    } else if (msgReply.Param == 'Save') {
                        document.getElementById("btnSaveSettings").value = msgReply.Result;
                    } else if (msgReply.Param == 'IDCANCEL') {
                        document.getElementById("btnCancelSave").value = msgReply.Result;
                    } else if (msgReply.Param == 'DeviceStatus') {
                        // strDeviceStatus = msgReply.Result;
                        strDeviceStatus = msgReply.Param;
                    } else if (msgReply.Param == 'DeviceName') {
                        strDeviceName = msgReply.Result;
                        // document.getElementById('deviceNameKey').innerHTML = strDeviceName + ":";
                        document.getElementById('deviceNameKey').innerHTML = "Nama Device" + ":";
                    } else if (msgReply.Param == 'DeviceSerialno') {
                        strDeviceSerialno = msgReply.Result;
                        // document.getElementById('deviceSerialKey').innerHTML = strDeviceSerialno + ":";
                        document.getElementById('deviceSerialKey').innerHTML = "No Serial" + ":";
                    } else if (msgReply.Param == 'DeviceNotConnected') {
                        strDevNotConnect = msgReply.Result;
                    } else if (msgReply.Param == 'DescOfWebsocketError') {
                        strDescOfWebsocketError = msgReply.Result;
                    } else if (msgReply.Param == 'DescFailSetRFID') {
                        strDescFailSetRFID = msgReply.Result;
                    } else if (msgReply.Param == 'DescFailSetVIZ') {
                        strDescFailSetVIZ = msgReply.Resultl;
                    } else if (msgReply.Param == 'PlaceHolderCardTextInfo') {
                        // strPlaceHolderCardTextInfo = msgReply.Result;
                        // document.getElementById("msg").setAttribute("placeholder", strPlaceHolderCardTextInfo);
                    } else if (msgReply.Param == 'DescFailSendWebsocket') {
                        strDescFailSendWebsocket = msgReply.Result;
                    } else if (msgReply.Param == 'DeviceOffLine') {
                        strDeviceOffLine = msgReply.Result;
                    } else if (msgReply.Param == 'DeviceReconnected') {
                        strDeviceReconnected = msgReply.Result;
                    } else if (msgReply.Param == 'WebDescDeviceNotFound') {
                        strWebDescDeviceNotFound = msgReply.Result;
                    } else if (msgReply.Param == 'WebDescRequireRestartSvc') {
                        strWebDescRequireRestartSvc = msgReply.Result;
                    } else if (msgReply.Param == 'WebDescAskForSupport') {
                        strWebDescAskForSupport = msgReply.Result;
                    } else if (msgReply.Param == 'WebDescRequireReconnect') {
                        strWebDescRequireReconnect = msgReply.Result;
                    } else if (msgReply.Param == 'DeviceConnected') {
                        strDeviceConnected = msgReply.Result;
                    }
                }
            } else if (msgReply.Succeeded == 'N') {
                if (msgReply.Operand == 'TakePhotoOcr') {

                    document.getElementById("errorMessageKey").style.display = 'inline';
                    document.getElementById("errorMessage").innerHTML = msgReply.Result;

                }
            }
        } else if (msgReply.Command == 'Set') {
            if (msgReply.Succeeded == 'N') { /* Set指令未生效 */
                if (msgReply.Operand == 'RFID') {
                    document.getElementById("msg").innerHTML = strDescFailSetRFID;
                } else if (msgReply.Operand == 'VIZ') {
                    //document.getElementById("msg").innerHTML = strDescFailSetVIZ;
                }
            }

        }
        // console.log(msgReply);

    }

    /* 后台服务主动向web端发送消息，包括读卡信息、证件图像以及异常状态通知等 */
    function processNotify(msgNotify) {
        document.getElementById("errorMessageKey").style.display = "none";
        document.getElementById("errorMessage").innerHTML = "";
        if (msgNotify.Command == 'Display') {
            if (msgNotify.Param == strAcquireImageFailed) {
                clrTextInfo()
                clrImages(true);
                document.getElementById("errorMessageKey").style.display = 'inline';
                document.getElementById("errorMessage").innerHTML = strAcquireImageFailed;
            }
            if (msgNotify.Param == strRecogFailed) {
                clrTextInfo()
                clrImages(true);
                document.getElementById("errorMessageKey").style.display = 'inline';
                document.getElementById("errorMessage").innerHTML = strRecogFailed;
            }
            if (msgNotify.Param == strDeviceOffLine) {
                clrDeviceStatus();
                document.getElementById('deviceStatus').innerHTML = strWebDescDeviceNotFound; // "WebSocket已连接, 未检测到设备";
                document.getElementById('deviceStatus').style.color = '#f00';
            } else if (msgNotify.Param == strDeviceReconnected) {
                getDeviceStatus();
            }
            else if (msgNotify.Param == strInitIDCardFailed) {
                document.getElementById('deviceStatus').innerHTML = strInitIDCardFailedMessage;
                document.getElementById('deviceStatus').style.color = '#f00';
            }
        } else if (msgNotify.Command == 'Reconnect') {
            clrDeviceStatus();
            document.getElementById('deviceStatus').innerHTML = strWebDescRequireReconnect; // "WebSocket服务要求web端重新建立连接，正在重连";
            document.getElementById('deviceStatus').style.color = '#f00';
            disConnect();
            connect();

        } else if (msgNotify.Command == 'AskSupport') {
            clrDeviceStatus();
            document.getElementById('deviceStatus').innerHTML = strWebDescAskForSupport; // "WebSocket服务遇到问题：" + msgNotify.Param;
            document.getElementById('deviceStatus').style.color = '#f00';
        } else if (msgNotify.Command == 'RestartService') {
            /* disConnect(); */
            document.getElementById('deviceStatus').innerHTML = strWebDescRequireRestartSvc; // "WebSocket服务需要重新启动，请联系管理员";
            document.getElementById('deviceStatus').style.color = '#f00';
        } else if (msgNotify.Command == 'Save') {
            if (msgNotify.Operand == 'CardContentText') {
                // clrImages(false);
                displayCardContent(msgNotify.Param);
                datatampung[0] = msgNotify.Param;
            } else if (msgNotify.Operand == 'Images') {
                clrImages(false);
                displayImages(msgNotify.Param);
                datatampung[1] = msgNotify.Param;
                console.log(datatampung);
                if (datatampung.length == 2) {
                    $.ajax({
                        url: "{{ route('registrasi_pasien_reader_passport_scan') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": datatampung
                        },
                        dataType: 'html',
                    }).done(function (data) {

                        $('#divTextArea').html(data);
                    }).fail(function () {

                    });
                } else {

                }
            } else if (msgNotify.Operand == 'DocInfoAllInOne') {
                displayCardContent(msgNotify.Param.Fields);
                displayImages(msgNotify.Param.Images);
            }
        } else if (msgNotify.Command == 'CardDetected') {
            clrTextInfo()
            clrImages(true);

        }


    }

    /*  解析证件文本信息（JSON格式）并展示到页面 */
    function displayCardContent(cardContent) {
        // console.log(cardContent);


    }

    // DATA TAMPUNG
    function tryDisplayImage(images, imageName, domId) {
        if (images.hasOwnProperty(imageName)) {
            document.getElementById(domId).src = images[imageName];

            if (bigImageEmpty) {
                document.getElementById("imageDisplay").src = images[imageName];
                bigImageEmpty = false;

            }
        }
    }

    /* 检查由后台发送的图像数据中包含哪些图像，并展示到页面 */
    function displayImages(images) {
        tryDisplayImage(images, "White", "imageWhite");
        tryDisplayImage(images, "IR", "imageIR");
        tryDisplayImage(images, "UV", "imageUV");
        tryDisplayImage(images, "OcrHead", "imageOcrHead");
        tryDisplayImage(images, "ChipHead", "imageChipHead");
        tryDisplayImage(images, "SidHead", "imageChipHead");
        return images;

    }

    function clrTextInfo() {
        document.getElementById("divTextArea").innerHTML = "";
    }

    /* 清空页面上的图像信息 */
    function clrImages(bForce) {
        if (bForce || !bCardDetectedNotification) {
            document.getElementById("imageWhite").src = "{{ asset('png/Home_pic_bgicon.png') }}";
            document.getElementById("imageIR").src = "{{ asset('png/Home_pic_bgicon.png') }}";
            document.getElementById("imageUV").src = "{{ asset('png/Home_pic_bgicon.png') }}";
            document.getElementById("imageOcrHead").src = "{{ asset('png/Home_pic_bgicon.png') }}";
            document.getElementById("imageChipHead").src = "{{ asset('png/Home_pic_bgicon.png') }}";
            document.getElementById("imageDisplay").src = "{{ asset('png/Home_pic_kong.png') }}";
            bigImageEmpty = true;
        }
    }

    /* 将发送数据的操作做了封装 */
    function sendJson(jsonData) {
        try {
            if (websocket !== null) {
                websocket.send(JSON.stringify(jsonData));
            }
        } catch (exception) {
            document.getElementById("msg").innerHTML = strDescFailSendWebsocket;

        }
    }


    function onGetOnlineStatusEx() {
        var cmdGetOnlineStatusEx = {
            Type: "Request",
            Command: "Get",
            Operand: "OnLineStatusEx",
        };
        sendJson(cmdGetOnlineStatusEx);
    }

    function onManualTrigger() {
        var cmdManualTrigger = {
            Type: "Notify",
            Command: "Trigger",
            Operand: "ManualRecog",
            Param: 2
        };

        sendJson(cmdManualTrigger);
    }

    function ScanDocument() {
        var cmdScanDocument = {
            Type: "Notify",
            Command: "TriggerEx",
            Operand: "ManualRecog",
            Param: {
                DocumentId: 2
            }
        };
        sendJson(cmdScanDocument);

    }

    // < !--新增，指定识别-- >
    function SpecifiedRecog() {
        var cmdSpecifiedRecog = {
            Type: "Notify",
            Command: "RecogMode",
            Operand: "RecogSpecified",
            Param: 2
        };

        sendJson(cmdSpecifiedRecog);
    }

    /* 获取设备状态、核心版本，一次性发送多条指令 */
    function getDeviceStatus() {
        var request = {
            Type: "Request",
            Commands: [
                { Command: "Get", Operand: "OnLineStatus" },  /* 获取设备在线状态 */
                { Command: "Get", Operand: "DeviceName" },    /* 获取设备名称 */
                { Command: "Get", Operand: "DeviceType" },    /* 获取设备类型(扫描仪或护照阅读机) */
                { Command: "Get", Operand: "DeviceSerialNo" }, /* 获取设备序列号 */
                { Command: "Get", Operand: "VersionInfo" } /* 获取核心版本信息 */
            ]
        };
        sendJson(request);
    }

    /*设置获取16进制DG数据*/
    function setDGContent() {
        var request = {
            Type: "Request",
            Command: "Set",
            Operand: "DGSource"
        };
        sendJson(request);
    }

    /* 清空页面上显示的设备状态信息 */
    function clrDeviceStatus() {
        document.getElementById("deviceStatus").innerHTML = "Offline";
        document.getElementById("deviceStatus").style.color = "000";
        document.getElementById("deviceNameKey").style.display = "none";
        document.getElementById('deviceName').innerHTML = "";
        document.getElementById("deviceSerialKey").style.display = "none";
        document.getElementById('deviceSerial').innerHTML = "";

    }

    /* 设置读卡参数，默认识别芯片信息、识别版面信息 */
    function setDefaultSettings() {
        var request = {
            Type: "Request",
            Commands: [
                { Command: "Set", Operand: "RFID", Param: "Y" }, /* 设置识别芯片信息 */
                { Command: "Set", Operand: "VIZ", Param: "Y" }   /* 设置识别版面信息 */
            ]
        };

        sendJson(request);
    }

    function takePhoto() {
        var request = {
            Type: "Request",
            Command: "Set",
            Operand: "TakePhoto",
            Param: 21
        };
        var requestGetBase64 = {
            Type: "Request",
            Command: "Get",
            Operand: "Base64Image"
        };

        sendJson(request);
        sendJson(requestGetBase64);
    }

    function takePhotoOcr() {
        clrTextInfo();
        clrImages();
        var request = {
            Type: "Request",
            Command: "Get",
            Operand: "TakePhotoOcr",
            Param: 21
        };
        sendJson(request);
        console.log(request);

    }


    /* 选择要放大观看的图像 */
    function showImage(domId) {
        document.getElementById("imageDisplay").src = document.getElementById(domId).src;
    }

    function showSettingPage() {
        document.getElementById("settings").style.display = "block";
        document.getElementById("control").style.display = "none";
        document.getElementById("cardInfo").style.display = "none";
    }

    function checkStatusToString(domId) {
        if (document.getElementById(domId).checked) {
            return "True";
        } else {
            return "False";
        }
    }

    function SaveSettings() {
        bCardDetectedNotification = document.getElementById("CallBack").checked || document.getElementById("CardDetect").checked;

        var request = {
            Type: "Request",
            Commands: [
                { Command: "Set", Operand: "VIZ", Param: checkStatusToString("RecogVIZ") },
                { Command: "Set", Operand: "RFID", Param: checkStatusToString("RecogRFID") },
                { Command: "Set", Operand: "Rejection", Param: checkStatusToString("Rejection") },
                { Command: "Set", Operand: "IfEnableCallback", Param: checkStatusToString("CallBack") },
                { Command: "Set", Operand: "IfNotifyCardDetected", Param: checkStatusToString("CardDetect") },
                { Command: "Set", Operand: "MRZOnWhiteImage", Param: checkStatusToString("MRZOnWhite") },
                { Command: "Set", Operand: "IfDetectUVDull", Param: checkStatusToString("UVDull") },
                { Command: "Set", Operand: "IfDetectFibre", Param: checkStatusToString("Fibre") },
                { Command: "Set", Operand: "IfCheckSourceType", Param: checkStatusToString("SourceType") },
                { Command: "Set", Operand: "BarCodeRecog", Param: checkStatusToString("BarCode") }
            ]
        };

        sendJson(request);

        document.getElementById("settings").style.display = "none";
        document.getElementById("control").style.display = "block";
        document.getElementById("cardInfo").style.display = "block";
    }

    function DonnotSaveSettings() {
        document.getElementById("settings").style.display = "none";
        document.getElementById("control").style.display = "block";
        document.getElementById("cardInfo").style.display = "block";
    }
    function ChangeConnectType() {
        // var tmp = "http://127.0.0.1:90/";
        if (tmp == host) {
            host = "'http://127.0.0.1:90/";
        }
        else {

            host = "http://127.0.0.1:90/";
        }
    }

    function getWebConstants() {
        var request = {
            Type: "Request",
            Commands: [
                { Command: "Get", Operand: "WebConstant", Param: "CardRecogSystem" },
                { Command: "Get", Operand: "WebConstant", Param: "Connect" },
                { Command: "Get", Operand: "WebConstant", Param: "Disconnect" },
                { Command: "Get", Operand: "WebConstant", Param: "Save" },
                { Command: "Get", Operand: "WebConstant", Param: "IDCANCEL" },
                { Command: "Get", Operand: "WebConstant", Param: "DeviceStatus" },
                { Command: "Get", Operand: "WebConstant", Param: "DeviceName" },
                { Command: "Get", Operand: "WebConstant", Param: "DeviceSerialno" },
                { Command: "Get", Operand: "WebConstant", Param: "DeviceNotConnected" },
                { Command: "Get", Operand: "WebConstant", Param: "DescOfWebsocketError" },
                { Command: "Get", Operand: "WebConstant", Param: "DescFailSetRFID" },
                { Command: "Get", Operand: "WebConstant", Param: "DescFailSetVIZ" },
                { Command: "Get", Operand: "WebConstant", Param: "PlaceHolderCardTextInfo" },
                { Command: "Get", Operand: "WebConstant", Param: "DeviceOffLine" },
                { Command: "Get", Operand: "WebConstant", Param: "DeviceReconnected" },
                { Command: "Get", Operand: "WebConstant", Param: "DescFailSendWebsocket" },
                { Command: "Get", Operand: "WebConstant", Param: "WebDescDeviceNotFound" },
                { Command: "Get", Operand: "WebConstant", Param: "WebDescRequireRestartSvc" },
                { Command: "Get", Operand: "WebConstant", Param: "WebDescAskForSupport" },
                { Command: "Get", Operand: "WebConstant", Param: "WebDescRequireReconnect" },
                { Command: "Get", Operand: "WebConstant", Param: "DeviceConnected" }
            ]
        };

        sendJson(request);
        console.log(request);

    }

    function ChangeDeviceType() {
        var domDevType = document.getElementById("DevType");
        /*
        if (domDevType.options[domDevType.selectedIndex].value == 'PassportReader') {
            alert("护照阅读机");
        } else {
            alert("扫描仪");
        }
        */
        domDevType.selectedIndex = domDevType.defaultIndex;
    }

    function SetReadSidChip(param) {
        var request = {
            Type: "Request",
            Command: "Set",
            Operand: "Sid",
            Param: {
                OnlyReadChip: param
            }
        };

        sendJson(request);
    }

    function change() {
        var inputElement = document.getElementsByName("getElementsByName");

        if (inputElement.checked) {
            document.getElementById("connection").style.display = 'inline-block';
            autoReconnect = false;
            inputElement.checked = false;
        } else {

            document.getElementById("connection").style.display = 'none';
            autoReconnect = true;
            if (websocket == null) {
                connect();

            }
            inputElement.checked = true;
        }
    }
    function ambil_semua(data, images) {

    }
</script>


<div id="divPageTitle" style="display: none;">
    <h1>Sistem pengenalan kartu identitas </h1>
</div>
<div class="card-body">
    <div id="pannel">
        <div id="settings" style="display:none">
            <input type="checkbox" id="RecogVIZ" checked />RecogVIZ<br />
            <input type="checkbox" id="RecogRFID" checked />RecogRFID<br />
            <input type="checkbox" id="Rejection" />Rejection<br />
            <input type="checkbox" id="BarCode" />BarCode<br />
            <input type="checkbox" id="CallBack" />CallBack<br />
            <input type="checkbox" id="CardDetect" />CardDetect<br />
            <input type="checkbox" id="MRZOnWhite" />MRZOnWhite<br />
            <input type="checkbox" id="UVDull" />UVDull<br />
            <input type="checkbox" id="Fibre" />Fibre<br />
            <input type="checkbox" id="SourceType" />SourceType<br />
            <input type="button" id="btnSaveSettings" value="保存" onclick="SaveSettings();" />
            <input type="button" id="btnCancelSave" value="取消" onclick="DonnotSaveSettings();" />
        </div>
        <div id="control">
            <div style="color:#333; font-size:18px;padding-left: 10px;display: inline-block;">
                <input type="checkbox" name="autoconnection" checked="checked" value="connecting" onchange="change()">
                Terhubung secara otomatis
            </div>

            <input type="button" value="设置识读选项" onclick="showSettingPage();" style="display:none" />
            <input type="button" data-value="ToBeConnect" id="connection" onclick="onConnection();" />
            <input type="button" value="Take Photos" id="TakePhotos" onclick="takePhotoOcr();" style="display:none" />
            <input id="idSpecifiedRecog" type="button" value="Specified Recog" onclick="SpecifiedRecog();"
                style="display:none" />

            <input type="button" value="Manual Trigger" id="ManualTrigger" onclick="onManualTrigger();"
                style="display:none" />
            <input type="button" value="二代证只读芯片" id="ReadSIDChip" onclick="SetReadSidChip('True');"
                style="display:none" />
            <input type="button" value="二代证识别+读卡" id="NotReadSidChip" onclick="SetReadSidChip('False');"
                style="display:none" />
            <span style="display: none;">
                <select id="DevType" onfocus="this.defaultIndex=this.selectedIndex;"
                    onchange="this.selectedIndex=this.defaultIndex;">
                    <option value="PassportReader">PassportReader</option>
                    <option value="Scanner">Scanner</option>
                </select>
                <select id="httpOrHttps" onchange="ChangeConnectType();">
                    <option value="http">http</option>
                    <option value="https">https</option>
                </select>
            </span>
            <div id="divPaddingDummy">
            </div>
            <div id="divDevStatus">
                <input id="idScanDocument" type="button" value="扫描识别" onclick="ScanDocument();" style="display:none" />
                <span id="deviceStatus">Layanan WebSocket yang menghubungkan...</span>
                <span id="deviceNameKey" class="cDevStatusKey" style="display:none">Nama perangkat :</span>
                <span id="deviceName"></span>
                <span id="deviceSerialKey" class="cDevStatusKey" style="display:none">Nomor seri perangkat :</span>
                <span id="deviceSerial"></span>
                <span id="errorMessageKey" class="cDevStatusKey" style="display:none">错误提示:</span>
                <span id="errorMessage"></span>
            </div>
        </div>
        <div id="cardInfo" style="display: none;">

            <div id="divImages">
                <div id="divSmallImages">
                    <div class="cDivSmallImage">
                        <img id="imageWhite" class="cImage" src="{{ asset('png/Home_pic_bgicon.png') }}"
                            onclick="showImage('imageWhite');" />
                    </div>
                    <div class="cDivSmallImage">
                        <img id="imageIR" class="cImage" src="{{ asset('png/Home_pic_bgicon.png') }}"
                            onclick="showImage('imageIR');" />
                    </div>
                    <div class="cDivSmallImage">
                        <img id="imageUV" class="cImage" src="{{ asset('png/Home_pic_bgicon.png') }}"
                            onclick="showImage('imageUV');" />
                    </div>
                    <div class="cDivSmallImage">
                        <img id="imageOcrHead" class="cImage" src="{{ asset('png/Home_pic_bgicon.png') }}"
                            onclick="showImage('imageOcrHead');" />
                    </div>
                    <div class="cDivSmallImage">
                        <img id="imageChipHead" class="cImage" src="{{ asset('png/Home_pic_bgicon.png') }}"
                            onclick="showImage('imageChipHead');" />
                    </div>
                </div>
                <div id="divBigImage" align="center">
                    <img id="imageDisplay" class="bigImage" src="{{ asset('png/Home_pic_kong.png') }}" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div id="divTextArea">
    </div>
</div>
