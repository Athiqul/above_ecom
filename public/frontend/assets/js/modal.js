//console.log('hello');



function modalView(id)
{
      // console.log(id);
       const host = window.location.host;

       let url=window.location.protocol+'/product-modal/'+id;
       console.log(url);

       //fatech data
       fetch(url).then(res=>res.json()).then(res=>{
           // console.log(res);
            //Modal Heading
            let ModalHeading=document.getElementById('modalHeading');
            ModalHeading.innerText=res.product.product_name;
            ModalHeading.href='/product-details/'+res.product.id+'/'+res.product.product_slug;
            let modalImage=document.getElementById('modalImage');
            modalImage.src="/uploads/products/"+res.product.main_image;

            //Modal Price
            let price=document.getElementById('modalPrice');

            if(res.product.discount_price>0)
            {
                let html =` <span class="current-price text-brand">৳${res.product.discount_price}</span>
                <span>
                    <span class="save-price font-md color3 ml-15">${Math.round((res.product.discount_price-res.product.selling_price)/res.product.selling_price*100)}% Off</span>
                    <span class="old-price font-md ml-15">৳${res.product.selling_price}</span>
                </span>`;

                price.innerHTML=html;
            }else{
                let html=`<span class="current-price text-brand">৳${res.product.selling_price}</span>`;
                price.innerHTML=html;
            }

            let modalExtra=document.getElementById('modalExtra');
            modalExtra.innerHTML=` <ul>
            <li class="mb-5">Vendor: <span class="text-brand">${res.vendor==null?'owner':res.vendor.name}</span></li>
            <li class="mb-5">Brand:<span class="text-brand"> ${res.product.brand_name==null?'':res.product.brand_name}</span></li>
        </ul>

        <ul>
            <li class="mb-5">Category: <span class="text-brand">${res.product.category_name??''}</span></li>
            <li class="mb-5">Stock:<span class="${res.product.product_qty<1 ? 'text-danger':'text-brand'}">${res.product.product_qty<1 ? 'Stock Out':res.product.product_qty+' Stock In'}</span></li>
        </ul>`;

        let modalSize=document.getElementById('modalSize');
        let sizes=res.product.product_size.split(',');
        //console.log(sizes);
        if(sizes!=null)
        {
            let tem='';
            sizes.forEach(function(item){
                  tem+=`<option value='${item.charAt(0).toUpperCase()+item.slice(1)}'>${item.charAt(0).toUpperCase()+item.slice(1)}</option>`;
            });
            modalSize.innerHTML=tem;
        }



        let modalColor=document.getElementById('modalColor');
        let colors=res.product.product_color.split(',');
        //console.log(colors);
        if(colors!=null)
        {
            let cl='';
            colors.forEach(function(item){
                  cl+=`<option value='${item.charAt(0).toUpperCase()+item.slice(1)}'>${item.charAt(0).toUpperCase()+item.slice(1)}</option>`;
            });
            modalColor.innerHTML=cl;
        }

        //Maximum Quantity
        let qty=document.getElementById('quantity');
        qty.setAttribute('max',res.product.product_qty);


        document.getElementById('product_id').value=id;


       }).catch(err=>console.log(err));
}

//add for modal
function addCart(){
     let productId=document.getElementById('product_id').value;
     let qty=document.getElementById('quantity').value;
     let size=document.getElementById('modalSize').value;
     let color=document.getElementById('modalColor').value;

    // console.log(productId,qty,size,color);
     let url='/add-cart';
     fetch(url,{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type':'application/json',
        },
        body:JSON.stringify({
            'id':productId,
            'qty':qty,
            'size':size,
            'color':color,
        })
     }).then(res=>res.json()).then(res=>{
            console.log(res);
            if(res.errors==true)
            {
               toastr.error("Something wrong can't add product into carts")
            }else{
                toastr.success(res.msg);
            }

            cartList();
          document.getElementById('closeModal').click();
     }).catch(err=>console.log(err));
     //Sent to data in API

}


//add from product page

function addCartProduct(){
    let productId=document.getElementById('productId').value;
    let qty=document.getElementById('qtyProduct').value;
    let size=document.getElementById('productSize').value;
    let color=document.getElementById('productColor').value;

   // console.log(productId,qty,size,color);
    let url='/add-cart';
    fetch(url,{
       method:'POST',
       headers:{
           'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
           'Content-Type':'application/json',
       },
       body:JSON.stringify({
           'id':productId,
           'qty':qty,
           'size':size,
           'color':color,
       })
    }).then(res=>res.json()).then(res=>{
          // console.log(res);
           if(res.errors==true)
           {
              toastr.error("Something wrong can't add product into carts")
           }else{
               toastr.success(res.msg);
           }

           cartList();
         document.getElementById('closeModal').click();
    }).catch(err=>console.log(err));
    //Sent to data in API

}

//Show all items in cart

function cartList(){
    let url='/cart-items';
    fetch(url).then(res=>res.json()).then(res=>{
        let totalCart=document.getElementById('totalCart');
        totalCart.innerText=res.cartItem;
       // document.getElementById('smallCartCount1').innerText=res.cartItem;
        document.getElementById('smallCartCount2').innerText=res.cartItem;


        let html='';
       // console.log(res);
        for(const key in res.carts)
        {
            if(res.carts.hasOwnProperty(key))
            {
                const value=res.carts[key];
                html+=`  <li>
                <div class="shopping-cart-img">
                    <a href=""><img alt="Nest" height:"70px" width="70px" src="/uploads/products/${value.options.image}" /></a>
                </div>
                <div class="shopping-cart-title">
                    <h4><a href="">${value.name.slice(0,10)+'..'}</a></h4>
                    <h4><span>${value.qty} × </span>${value.price} = ৳${value.subtotal}</h4>
                </div>
                <div class="shopping-cart-delete">
                    <a id="${key}" onclick="deleteCart(this.id)"><i class="fi-rs-cross-small"></i></a>
                </div>
            </li>`;
            }
        }

        document.getElementById('cartList').innerHTML=html;
        document.getElementById('smallCartList').innerHTML=html;
        document.getElementById('totalPay').innerText='৳'+res.total;
        document.getElementById('smallCartTotal').innerText='৳'+res.total;
    }).catch(err=>console.log(err));
}

cartList();

//Delete Cart
function deleteCart($row)
{
   fetch('/remove-item/'+$row).then(res=>res.json()).then(res=>{
           //console.log(res);
           toastr.info(res.msg);
           cartList();
   }).catch(err=>console.log(err));
}
