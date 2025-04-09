<!DOCTYPE html>
<html>
<head>
    <title>consultation.com</title>
</head>
<body>
    <div class="container">
    <div class="row" style="display:flex;justify-content:space-between;border-radius:5px;">
        <div class="col-md-12"> 
            <div style="display: flex;">
                <div>
                <img src="{{asset('admin/dist/media/logos/tawasul.jpeg')}}" width="80" height="100">
                </div>
                <div style="background-color:#31859A;color:white;text-align:center;border-radius:5px;">
                <div>
                     <p style="font-size:8px;"> التواصل التقني للاتصالات وتقنية المعلومات</p> 
                        <p style="font-size:12px;">Tawasul Tech for Communications & Technology</p>
            </div>
                </div>
        </div>
           
                
            

        </div>    
    </div>
    <div class="row" style="text-align:center;">
        <p>عزيزي/تي المحترم/ــة،</p>
        <p>تحية طيبة..</p>
        <p>شكراً لكم للانضمام معنا في عائلة استشارة..</p>
        <h5>Dear {{ $details['name'] }}</h5>
        <p>Greetings of the day.!</p>
        <p style="font-size:8px;">Thank you for joining us in our consultation family..</p>

        <br>
        <hr>
        <h5>Thank you for your partnership!</h5>
        <p style="font-size:8px;" class="mb-2">Should you have any enquiries concerning this notification, please contact us on Email: Support@tawasultech.com</p>
    </div>


    <div  style="background-color:#31859A;color:white;text-align:center;border-radius:5px;" class="mt-2 mb-2">
    <p style="font-size:8px;" class="pt-3"> A4 Tower,12th floor Ghurnada Business Park, Riyadh, KSA</p> 
    <p style="font-size:8px;">Tel: 0115118156 <a href="#" style="text-decoration:none;color:white;">Email: info@tawasultech.com</a> Web: <a href="#" style="text-decoration:none;color:white;">www.tawasultech.com</a></p>
    </div> 
    
   
    </div>
   
<!--   
        <h1>{{ $details['title'] }}</h1> 
        <table cellspacing="0"> 
            <tr> 
            <p>{{ $details['body'] }}</p>
            </tr> 
        </table> 
    

    <p>Thank you</p> -->
</body>
</html>