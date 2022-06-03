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

            main {
            }

        </style>

        <title>
            @if ($preview)
                Preview
            @else
                Contrato {{$contract->number}}
            @endif

        </title>
    </head>
    <body>
        @if ($preview)
            <div id="watermark">
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
                PREVIEW<br/><br/>
            </div>
        @endif

        <div id="header">
            <img src="{{public_path('images/logoatt.svg')}}" alt="APP_NAME">
        </div>

        <main>
            <!-- The content of your PDF here -->
            {!! $description !!}
        </main>
    </body>
</html>
