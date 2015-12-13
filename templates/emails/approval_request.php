<?php

    // if(!isset($config)) $config = parse_ini_file('../../config.ini', true);

    // $params['createdBy'] = 'omar.yerden';
    // $params['requestBy'] = 'marcelo@leandergames.com';
    // $params['requestTitle'] = 'Actualizacinde Lega/Annie';
    // $params['requestDescription'] = 'Estamos necesitando actualizar lega y annie para habilitar Jackpots, asi como tambien el modulo Jackie Manager en el BoB';

    // $users = array('ignacio.modino', 'omar.yerden');
    // $servers = array('uat1', 'uat2', 'dev1', 'dev2');

    // $currentDate = date('Y-m-d H:i:s');

    // $insertedId = 929;

    // $approverEmail = 'omaryer@hotmail.com';

?>

<body style="margin:0; padding:0">
    <table width="100%">
        <tr>
            <td style="background:#EE3124; text-align: center; padding:20px;">
                <img src="cid:leander-logo" height="40px" style="padding:0 10px 0 20px; vertical-align:middle" />
                <span style="font-family: Helvetica; font-size:18px; color:#FFF; vertical-align:middle">Control Change</span>
            </td>
        </tr>
    </table>
    <table align="center" width="100%" style="max-width: 800px;">
        <tr><td>
        <table width="100%" style="padding:10px 10px;">
            <tr>
                <td style="font-family:Arial; font-weight:bold; color:#5F5F5F; font-size:14px; line-height: 20px;">Nueva peticion de cambio requiere autorizaci&oacute;n, creada por <span style="color:#a44f4f;"><?php echo $params['created_by'] ?></span> <br /> <span style="font-size:13px; color:#909090;">el <?php echo $params['date_created']; ?><span></td>
            </tr>
        </table>
        <table cellpadding="5" style="padding:10px 10px; font-family:Arial; font-size:14px; color:#5F5F5F;">
            <tr style="border-bottom:1px solid #111;">
                <td width="25%" style="text-align: right">Request By:</td>
                <td style="background:#eee;"><strong><?php echo $params['request_by']; ?></strong></td>
            </tr>
            <tr>
                <td width="25%" style="text-align: right">Executors:</td>
                <td style="display:block;">
                    <strong><?php echo implode($params['execute_by'], ', '); ?></strong>
                </td>
            </tr>
            <tr>
                <td width="25%" style="text-align: right">Servers:</td>
                <td style="display:block; background:#eee;">
                    <strong><?php echo implode($params['servers_to'], ', '); ?></strong>
                </td>
            </tr>
        </table>
        <table width="100%" style="padding:10px 10px;">
            <tr>
                <td style="padding:5px 10px;">
                    <span style="width:100%; font-family:Arial; color:#5F5F5F; font-weight: bold; font-size:14px;"><?php echo $params['change_title']; ?></span>
                </td>
            </tr>
        </table>
        <table width="100%" style="padding:0px 10px;">
            <tr>
                <td style="padding:5px 10px; background:#eee;">
                    <span style="width:100%; font-family:Arial; color:#5F5F5F; font-size:13px; line-height: 20px;"><?php echo $params['change_description']; ?></span>
                </td>
            </tr>
        </table>
        <table align="center" width="80%" cellpadding="20" style="padding:20px 10px; text-align: center;">
            <tr>
                <td><a href="http://192.168.0.179/LeanderDevPHP/coca/acceptRequest.php?h=<?php echo $params['accept_token'] ?>" style="padding:5px 25px; background:green; font-family:Arial; font-size:24px; color:#FFF; text-decoration:none;">Aprobar</a></td>
            </tr>
            <tr>
                <td><a href="http://192.168.0.179/LeanderDevPHP/coca/cancelRequest.php?h=<?php echo $params['reject_token'] ?>" style="padding:5px 25px; background:#EE3124; font-family:Arial; font-size:24px; color:#FFF; text-decoration:none;">Rechazar</a></td>
            </tr>
        </table>
    </td></tr>
    </table>
</body>

