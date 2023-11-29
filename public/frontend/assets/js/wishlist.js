console.log('from wishlist js');

function addWish(id)
{

    let url="/add-wishlist";
    fetch(url,{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type':'application/json',
        },
        body:JSON.stringify({
             product_id:id,
        }),
    })
    .then(res=>res.json())
    .then(res=>{
        console.log(res);
        if(res.errors)
        {
            toastr.error(res.msg);
        }else{
            toastr.success(res.msg);
        }
    })
    .catch(err=>console.log(err));
    return false;
}

//Wish list
function wishList()
{
    let url='/customer/wishlist';
    fetch(url).then(res=>res.json()).then(res=>{
      if(res!==null)
      {
         document.getElementById('wishCount').innerText=res.length;
         document.getElementById('wishCount1').innerText=res.length;



      }else{
        document.getElementById('wishCount').innerText=0;
        document.getElementById('wishCount1').innerText=0;
      }

    }).catch(err=>console.log(err));
}

wishList();
