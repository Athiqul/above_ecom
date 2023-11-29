console.log('from Compare js');

function addCompare(id)
{

    let url="/add-compare";
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
            compareList();
        }
    })
    .catch(err=>console.log(err));
    return false;
}

//Wish list
function compareList()
{
    let url='/customer/compare-count';
    fetch(url).then(res=>res.json()).then(res=>{
      if(res!==null)
      {

         console.log(res.total);
         document.getElementById('compareCount').innerText=res.total;
         document.getElementById('compareCount1').innerText=res.total;


      }else{

        document.getElementById('compareCount').innerText=0;
        document.getElementById('compareCount1').innerText=0;

      }

    }).catch(err=>console.log(err));
}

compareList();
