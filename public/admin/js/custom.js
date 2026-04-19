$(document).ready(function() // waits until the entire HTML page is loaded before running the script.Ensures that the input field (#current_pwd) exists in the DOM before attaching events.
{
    // Check if Admin Password is correct or not
    // $("#current_pwd") selects the input field with the ID current_pwd..keyup(function(){ ... }) means: whenever the user releases a key while typing in thatfield, the function inside will run.
    $("#current_pwd").keyup(function() 
    
    {
        var current_pwd = $("#current_pwd").val();
        // .val get's the current value of the inputbox
        // the current tyepd password saved into variable current_pwd
        $.ajax( 
            // this part sends data to the server with out refreshing the page
            {
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/verify-password',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp == "false"){
                    $("#verifyPwd").html("<font color='red'>Current Password is incorrect</font>");
                } else if(resp == "true"){
                    $("#verifyPwd").html("<font color='green'>Current Password is correct</font>");
                }
             }, 
            error:function() {
                alert("Error");
            }
        });
    });
    $(document).on('click','#deleteProfileImage',function(){
    if (confirm('Are you sure you want to remove your Profile Image?')) {
        var admin_id = $(this).data('admin-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'delete-profile-image',
            data:{admin_id:admin_id},
            success:function(resp){
                if(resp['status'] == true)
                alert(resp['message']);
                $('#profileImageBlock').remove();
            },
            error:function(){
                alert('Error occurred while deleting the image.');
            }
        });
    }
});

});

