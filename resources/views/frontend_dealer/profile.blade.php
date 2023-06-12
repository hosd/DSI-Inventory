@section('title', 'Dealer Profile')
<x-dealer-layout>
    @if ($errors->any())
            <div class="alert alert-danger row my-2 mx-4">
                <!-- <strong>Whoops!</strong> There were some problems with your input.<br><br> -->
                
                <div class="col-lg-6 col-6 text-end">
                    <button type="button" style="background-color: transparent;" class="close" data-dismiss="alert" aria-label="Close"  >×</button>
                </div>
                
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                
            </div>
            @endif
            @if ($message = Session::get('success'))

            <div class="alert alert-success row my-2 mx-4">
                <div class="col-lg-6 col-6">
                    <p style="margin-bottom: 0px !important;">{{ $message }}</p>
                </div>
                <div class="col-lg-6 col-6 text-end">
                    <button type="button" style="background-color: transparent;" class="close" data-dismiss="alert" aria-label="Close"  >×</button>
                </div>
            </div>
            @endif
            @if ($message = Session::get('danger'))

            <div class="alert alert-danger row my-2 mx-4">
                 <div class="col-lg-6 col-6">
                    <p style="margin-bottom: 0px !important;">{{ $message }}</p>
                </div>
               <div class="col-lg-6 col-6 text-end">
                    <button type="button" style="background-color: transparent;" class="close" data-dismiss="alert" aria-label="Close"  >×</button>
                </div>      
                
            </div>
            @endif

        <div style="background-color: black;">
                        <h2 class="heading_text text-white ps-4">Profile Management</h2>
                    </div>
                   <form action="{{ route('save-user-profile') }}" enctype="multipart/form-data" autocomplete="off" method="post" id="user_details_form" name="user_details_form">
                @csrf 
                <div class="user_details row">
                        <div class="col-lg-6 col-12">
                            
                                <div class="mb-2 inp-holder" >
                                     <label for="InputName" class="form-label">Name <span class="required" style="color: red;">*</span></label>
                                     <input type="text" id="name" name="name" class="form-control" value="{{auth()->user()->name}}">
                                </div>
                                <div class="mb-2 inp-holder">
                                    <label for="InputEmail" class="form-label">Email <span class="required" style="color: red;">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control"  value="{{auth()->user()->email}}" aria-describedby="emailHelp">
                                <p id="duplicatecheck-msg" style="color: red; display:none;">This email address already has a dealer user account. </p>
                                </div>
                                
                             
                        </div>
                        <div class="col-lg-6 col-12">
                            
                                <div class="mb-2 inp-holder">
                                    <label for="InputPhone" class="form-label">Mobile Number <span class="required" style="color: red;">*</span></label>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="{{auth()->user()->mobile_no}}">
                                </div>
                                
                              
                        </div>
                        
                        <div class="line-div" style="margin-bottom: 10px"></div>

                        <div class="text-end" style="margin-top: 10px">
                            <button type="submit" class="btn btn-primary text-end">Update</button>
                            <a class="btn btn-default" href="{{route('user-list')}}"> Back</a>                            
                            <input type="hidden" id="dealerID" name="dealerID" value="{{encrypt(auth()->user()->dealerID)}}" />
                            <input type="hidden" id="id" name="id" value="{{encrypt(auth()->user()->id)}}" />
                        </div>
                    </div>
                        </form>
</div>
    <x-slot name="script">
    </x-slot>
</x-dealer-layout>    