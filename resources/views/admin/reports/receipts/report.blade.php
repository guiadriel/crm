<html>
    <head>
        <style>
            @page {
                margin: 160px 100px;
            }
            /**
            * Define the width, height, margins and position of the watermark.
            **/
            #watermark {
                position: fixed;
                /**
                    Set a position in the page for your image
                    This should center it vertically
                **/
                top: 0;

                /** Change image dimensions**/
                height:   8cm;
                text-align:center;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
                opacity: 0.5;
                color: #F00;
                font-size: 25pt
            }

            #header {
                position: fixed;
                top: -80px;
                left: 0px;
                right: 0;
                height: 50px;

                /** Extra personal styles **/
                color: white;
                line-height: 35px;
                text-align: right;
            }

            #header img {
                height: 0.7cm;
            }

            .title-header {
                text-align:  left;
                margin-top: -70px;
            }

            h1 {
                color: #CCC;
            }

            main {
            }

            table {
                width: 100%;
                margin-top: 20px;
            }

            th {
                border-bottom: 1px solid #ccc;
                padding: 10px;
            }

            td {
                padding: 15px 10px;
            }

            p {
                padding: 0;
                margin: 0;
            }

            .text-left {
                text-align: left;
            }

            .text-right {
                text-align: right;
            }

            .text-center {
                text-align:center;
            }

            .border-top, .border-top td {
                border-top: 1px solid #ccc;
            }

            tfoot td {
                font-size: 16pt;
            }

            h1, h2, h4 {
                padding: 0;
                margin: 0;
            }

            m-4 {
                margin-top: 4rem;
            }

            mb-4 {
                margin-bottom: 20px !important;
            }

            .bold {
                font-weight: bold;
            }

            .footer {
                width: 100%;
                text-align:center;
            }

            .description {
                margin-bottom: 40px;

            }

            .description p {
                line-height: 32px;
            }

        </style>

        <title>
            RECIBO DE PAGAMENTO
        </title>
    </head>
    <body>
        <div id="header">
            <img src="{{public_path('images/logoatt.svg')}}" alt="APP_NAME">
        </div>

        <main>
            <div class="title-header" style='margin-bottom: 25px'>
                <strong>RECIBO DE PAGAMENTO</strong>
            </div>

            <div class="m-4 signature">
                @if ( $description != "")
                    <div class="description">
                        {!! $description !!}
                    </div>
                @else
                    <p style='margin-bottom: 40px;line-height:32px'>
                        TEXT BASE
                    </p>
                @endif

                <p style='margin: 40px 0;'>
                    @php
                        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                        date_default_timezone_set('America/Sao_Paulo');
                    @endphp
                    {{ ucfirst(strftime('City, %d de %B de %Y', strtotime('today'))) }}

                </p>

                <p>
                    _________________________________
                </p>
            </div>
        </main>
    </body>
</html>
