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
                margin-top: -85px;
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
                padding: 8px 10px;
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
                font-size: 14pt;
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
            CONTRATO [{{$contract->number}}]
        </title>
    </head>
    <body>
        <div id="header">
            <img src="{{public_path('images/logoatt.svg')}}" alt="CRM">
        </div>

        <main>
            <div class="title-header">
                <h1>CONTRATO</h1>
                <h2 class="mb-4" style='margin-bottom: 20px;'>{{ $contract->number }}</h2>
                <p>Aluno: {{ $contract->student->name ?? '' }}</p>
                <p>Data de início: {{ $contract->start_date }}</p>
            </div>

            <div class="content">
                <table class="table-borderless table-striped w-100 p-0 m-0">
                <thead>
                  <tr>
                    <th class='p-2 text-center' scope="row">#</th>
                    <th>VALOR</th>
                    <th>TIPO</th>
                    <th>STATUS</th>
                    <th>DATA</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($contract->payments as $payment)
                        <tr>
                            <td scope="row" class='text-center '>#{{$payment->sequence}}</td>
                            <td class="text-center">
                                @if ($payment->interest > 0)
                                    <span>
                                        @money($payment->value + $payment->interest)*
                                    </span>
                                @else
                                    @money($payment->value)
                                @endif
                            </td>
                            <td class="text-center">{{$payment->type}}</td>
                            <td class="text-center">{{$payment->status->description}}</td>
                            <td class="text-center">{{$payment->due_date}}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>

            <div class="footer " style='margin-top: 4rem;'>
                CRM © {{ date('Y')}}
            </div>
        </main>
    </body>
</html>
