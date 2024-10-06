

function savedata()
{ 
     
       var userid=$('#userid').val();

       var NewPassword=$('#NewPassword').val();
       var OldPassword=$('#OldPassword').val();
       var OldPass=$('#OldPass').val();
      
      if(OldPass!=OldPassword)
      {
          alert('Old Password is Wrong!');
      }
      else{

        var sql = "UPDATE users SET password='"+NewPassword+"' WHERE id="+userid;
        
       save_master(sql);
       id=0;
       ScrollToTop();
        
      }
         
       
}

