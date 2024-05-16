
@include('components.header')
<link href="{{ asset('css/support.css') }}" rel="stylesheet">


<div class="background">
    <div class="container">
        <div class="screen">
            <div class="screen-header">
                <div class="screen-header-left">
                    <div class="screen-header-button close"></div>
                    <div class="screen-header-button maximize"></div>
                    <div class="screen-header-button minimize"></div>
                </div>
                <div class="screen-header-right">
                    <div class="screen-header-ellipsis"></div>
                    <div class="screen-header-ellipsis"></div>
                    <div class="screen-header-ellipsis"></div>
                </div>
            </div>
            <div class="screen-body">
                <div class="screen-body-item left">
                    <div class="app-title">
                        <span>CONTACT</span>
                        <span>US</span>
                    </div>
                    <div class="app-contact">CONTACT INFO : +961 71 387 946 <br>CONTACT INFO : +961 81 077 213 </div>

                </div>
                <div class="screen-body-item">
                    <div class="app-form">
                        <div class="app-form-group">
                            <input class="app-form-control" placeholder="NAME">
                        </div>
                        <div class="app-form-group">
                            <input class="app-form-control" placeholder="EMAIL">
                        </div>

                        <div class="app-form-group message">
                            <input class="app-form-control" placeholder="MESSAGE">
                        </div>
                        <div class="app-form-group buttons">
                            <button class="app-form-button">CANCEL</button>
                            <button class="app-form-button">SEND</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@include('components.footer')
