<html>
    <head>
        <style>
            @page {
                margin: 120px 80px 80px 80px;
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
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                color: white;
                line-height: 35px;
            }

            #header img {
                height: 1.5cm;
            }

            .title-header {
                text-align:  right;
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

        </style>

        <title>
            RECIBO [{{$teacher->name}}]
        </title>
    </head>
    <body>
        <div id="header">
            <img src="{{public_path('images/logoatt.svg')}}" alt="APP_NAME">
        </div>

        <main>
            <div class="title-header">
                <h1>RECIBO</h1>
                <h2 class="mb-4" style='margin-bottom: 20px;'>{{ $teacher->name }}</h2>
                <p>{{ $teacher->email }}</p>
                <p>{{ $teacher->phone }}</p>
            </div>

            <div class="content">
                <table cellspacing=0 class="table table-sm table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-left">Tipo</th>
                            <th class="text-center">Quantidade de aulas dadas</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">VIP</td>
                            <td class="font-weight-bold text-center">{{ $reportData['resume']['vip']['count'] }}</td>
                            <td class="font-weight-bold text-right">@money($reportData['resume']['vip']['amount'])</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">TURMA</td>
                            <td class="font-weight-bold text-center">{{ $reportData['resume']['turma']['count'] }}</td>
                            <td class="font-weight-bold text-right">@money($reportData['resume']['turma']['amount'])</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-top">
                            <td></td>
                            <td class="text-center"><h4 class="m-0 font-weight-bold"> {!! $reportData['resume']['turma']['count'] + $reportData['resume']['vip']['count'] !!}</h4></td>
                            <td class="text-right py-2 m-0"><h4 class="m-0 d-inline font-weight-bold">@money($reportData['resume']['total'])</h4></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="m-4 signature">
                <p style='margin-bottom: 40px;'>
                    Declaro que recebi a quantia de R$ @money($reportData['resume']['total']), referente ao período entre {{ $initialDate}} e {{ $finalDate}} .
                </p>

                _________________________________
                <p class="bold">{{ $teacher->name }} </p>

                <p style='margin: 15px 0;'>
                    @php
                        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                        date_default_timezone_set('America/Sao_Paulo');
                    @endphp
                    {{ ucfirst(strftime('%A, %d de %B de %Y', strtotime('today'))) }}

                </p>
            </div>

            <div class="footer">
                APP_NAME © {{ date('Y')}}
            </div>
        </main>
    </body>
</html>
