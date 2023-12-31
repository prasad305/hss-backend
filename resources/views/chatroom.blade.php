<!DOCTYPE html>
<html lang="en">
    <head>
        <title itemprop="name">Preview Bootstrap snippets. white chat</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style type="text/css">
                body {
                    margin-top: 20px;
                }

                .chat-online {
                    color: #34ce57;
                }

                .chat-offline {
                    color: #e4606d;
                }

                .chat-messages {
                    display: flex;
                    flex-direction: column;
                    max-height: 800px;
                    overflow-y: scroll;
                }

                .chat-message-left,
                .chat-message-right {
                    display: flex;
                    flex-shrink: 0;
                }

                .chat-message-left {
                    margin-right: auto;
                }

                .chat-message-right {
                    flex-direction: row-reverse;
                    margin-left: auto;
                }
                .py-3 {
                    padding-top: 1rem !important;
                    padding-bottom: 1rem !important;
                }
                .px-4 {
                    padding-right: 1.5rem !important;
                    padding-left: 1.5rem !important;
                }
                .flex-grow-0 {
                    flex-grow: 0 !important;
                }
                .border-top {
                    border-top: 1px solid #dee2e6 !important;
                }
            </style>
    </head>
    <body>
        <div id="snippetContent">
            <main class="content">
                <div class="container p-0">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-12 col-lg-5 col-xl-3 border-right">

                                @php $users = App\Models\User::all(); @endphp


                                @foreach($users as $user)

                                <a href="#" class="list-group-item list-group-item-action border-0">
                                    <div class="badge bg-success float-right">5</div>
                                    <div class="d-flex align-items-start">
                                        <img src="https://koolinus.files.wordpress.com/2019/03/avataaars-e28093-koolinus-1-12mar2019.png" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40" />
                                        <div class="flex-grow-1 ml-3">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                            <div class="small" id="status_{{ $user->id }}">
                                                @if($user->is_online == 1)
                                                <span class="fa fa-circle chat-online"></span> Online</div>
                                                @else
                                                <span class="fa fa-circle chat-offline"></span> Offline</div>
                                                @endif
                                        </div>
                                    </div>
                                </a>

                                @endforeach




                                <a href="#" class="list-group-item list-group-item-action border-0">
                                    <div class="badge bg-success float-right">2</div>
                                    <div class="d-flex align-items-start">
                                        <img src="https://koolinus.files.wordpress.com/2019/03/avataaars-e28093-koolinus-1-12mar2019.png" class="rounded-circle mr-1" alt="William Harris" width="40" height="40" />
                                        <div class="flex-grow-1 ml-3">
                                            William Harris
                                            <div class="small"><span class="fa fa-circle chat-online"></span> Online</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action border-0">
                                    <div class="d-flex align-items-start">
                                        <img src="https://koolinus.files.wordpress.com/2019/03/avataaars-e28093-koolinus-1-12mar2019.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                        <div class="flex-grow-1 ml-3">
                                            Sharon Lessman
                                            <div class="small"><span class="fa fa-circle chat-online"></span> Online</div>
                                        </div>
                                    </div>
                                </a>
                                <hr class="d-block d-lg-none mt-1 mb-0" />
                            </div>
                            <div class="col-12 col-lg-7 col-xl-9">
                                <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                    <div class="d-flex align-items-center py-1">
                                        <div class="position-relative"><img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" /></div>
                                        <div class="flex-grow-1 pl-3">
                                            <strong>Sharon Lessman</strong>
                                            <div class="text-muted small"><em>Typing...</em></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <div class="chat-messages p-4">
                                        <div class="chat-message-right pb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:33 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                <div class="font-weight-bold mb-1">You</div>
                                                Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.
                                            </div>
                                        </div>
                                        <div class="chat-message-left pb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:34 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                                Sit meis deleniti eu, pri vidit meliore docendi ut, an eum erat animal commodo.
                                            </div>
                                        </div>
                                        <div class="chat-message-right mb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:35 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                <div class="font-weight-bold mb-1">You</div>
                                                Cum ea graeci tractatos.
                                            </div>
                                        </div>
                                        <div class="chat-message-left pb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:36 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                                Sed pulvinar, massa vitae interdum pulvinar, risus lectus porttitor magna, vitae commodo lectus mauris et velit. Proin ultricies placerat imperdiet. Morbi varius quam ac venenatis tempus.
                                            </div>
                                        </div>
                                        <div class="chat-message-left pb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:37 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                                Cras pulvinar, sapien id vehicula aliquet, diam velit elementum orci.
                                            </div>
                                        </div>
                                        <div class="chat-message-right mb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:38 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                <div class="font-weight-bold mb-1">You</div>
                                                Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.
                                            </div>
                                        </div>
                                        <div class="chat-message-left pb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:39 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                                Sit meis deleniti eu, pri vidit meliore docendi ut, an eum erat animal commodo.
                                            </div>
                                        </div>
                                        <div class="chat-message-right mb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:40 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                <div class="font-weight-bold mb-1">You</div>
                                                Cum ea graeci tractatos.
                                            </div>
                                        </div>
                                        <div class="chat-message-right mb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:41 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                <div class="font-weight-bold mb-1">You</div>
                                                Morbi finibus, lorem id placerat ullamcorper, nunc enim ultrices massa, id dignissim metus urna eget purus.
                                            </div>
                                        </div>
                                        <div class="chat-message-left pb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:42 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                                Sed pulvinar, massa vitae interdum pulvinar, risus lectus porttitor magna, vitae commodo lectus mauris et velit. Proin ultricies placerat imperdiet. Morbi varius quam ac venenatis tempus.
                                            </div>
                                        </div>
                                        <div class="chat-message-right mb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:43 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                <div class="font-weight-bold mb-1">You</div>
                                                Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.
                                            </div>
                                        </div>
                                        <div class="chat-message-left pb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                                <div class="text-muted small text-nowrap mt-2">2:44 am</div>
                                            </div>
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                                Sit meis deleniti eu, pri vidit meliore docendi ut, an eum erat animal commodo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-0 py-3 px-4 border-top">
                                    <div class="input-group"><input type="text" class="form-control" placeholder="Type your message" /> <button class="btn btn-primary">Send</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.js" integrity="sha512-MgkNs0gNdrnOM7k+0L+wgiRc5aLgl74sJQKbIWegVIMvVGPc1+gc1L2oK9Wf/D9pq58eqIJAxOonYPVE5UwUFA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


        <script>

            $(function(){
                var user_id = {{Auth::id()}};
                var socket = io("http://localhost:8800",{query:{user_id}});


                socket.on('user_connected', function(data){
                    //alert(data);
                    $("#status_"+data).html('<span class="fa fa-circle chat-online"></span> Online');
                });

                socket.on('user_disconnected', function(data){
                    $("#status_"+data).html('<span class="fa fa-circle chat-offline"></span> Offline');
                });
            });

        </script>

    </body>
</html>
