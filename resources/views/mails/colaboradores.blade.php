<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<?php
$style = [
    /* Layout ------------------------------ */
        'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
        'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',
    /* Masthead ----------------------- */
        'email-masthead' => 'background:gray; text-align: center;',
        'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',
        'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
        'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
        'email-body_cell' => 'padding: 35px;',
        'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
        'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',
    /* Body ------------------------------ */
        'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
        'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',
    /* Type ------------------------------ */
        'anchor' => 'color: #3869D4;',
        'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
        'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
        'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
        'paragraph-center' => 'text-align: center;',
    /* Buttons ------------------------------ */
        'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',
        'button--green' => 'background-color: #22BC66;',
        'button--red' => 'background-color: #dc4d2f;',
        'button--blue' => 'background-color: #3869D4;',
];
?>
<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>
<body style="{{ $style['body'] }}">

<table border="0" cellpadding="0" cellspacing="0" width="100%">

    <tr>

        <td>
            <!--hello-->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">

                <tr>
                    <td align="center" bgcolor="#110F0A" style="padding: 40px 0 30px 0;">
                        <img src="{{asset('images/logo_elite_mail.gif')}}" alt="eliteexperiencevip" width="200" height="150" style="display: block;" />
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <!--row2-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <b>Mensaje de colaboradores!</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0;">
                                    El usuario {{$detalle['nombre']}} te ha enviado un mensaje del formulario de colaboradores.
                                </td>
                            </tr>

                            <tr><td style="padding: 5px 0 5px 0;" align="left"><b>Su nombre</b> : {{$detalle['nombre']}}</td></tr>
                            <tr><td style="padding: 5px 0 5px 0;" align="left"><b>Su e-mail</b> : {{$detalle['email']}} </td></tr>
                            <tr><td style="padding: 5px 0 5px 0;" align="left"><b>Su teléfono</b> : {{$detalle['telefono']}} </td></tr>
                            <tr><td style="padding: 5px 0 5px 0;" align="left"><b>Su ocupación</b> : {{$detalle['ocupacion']}} </td></tr>
                            <tr><td style="padding: 5px 0 5px 0;" align="left"><b>Trabajos previos</b>:  {{$detalle['trabajos']}} </td></tr>


                        </table>
                        <!--row2-->
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#110F0A" style="padding: 30px 30px 30px 30px;">
                        <!--row3 col2-->
                        <table style="{{ $style['email-footer'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="{{ $fontFamily }} {{ $style['email-footer_cell'] }}"><p style="{{ $style['paragraph-sub'] }}"> &copy; {{ date('Y') }} <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">eliteexperiencevip.com</a>.
                                        Todos los derechos reservados. </p></td>
                            </tr>
                        </table>
                        <!--row3 col2-->
                    </td>
                </tr>
            </table>
            <!--hello-->
        </td>
    </tr>
</table>

<!---nuevo diseño->






</body>
</html>