console.log('hello');

function modalView(id)
{
      // console.log(id);
       const host = window.location.host;

       let url=window.location.protocol+'/product-modal/'+id;
       console.log(url);

       //fatech data
       fetch(url).then(res=>res.json()).then(res=>{
            console.log(res);
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
            <li class="mb-5">Stock:<span class="${res.product.product_qty<1 ? 'text-danger':'text-brand'}">${res.product.product_qty<1 ? 'Stock Out':'Stock In'}</span></li>
        </ul>`;

        let modalSize=document.getElementById('modalSize');
        let sizes=res.product.product_size.split(',');
        //console.log(sizes);
        if(sizes!=null)
        {
            let tem='';
            sizes.forEach(function(item){
                  tem+=`<li><a href="#">${item.charAt(0).toUpperCase()+item.slice(1)}</a></li>`
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
                  cl+=`<li><a href="#">${item.charAt(0).toUpperCase()+item.slice(1)}</a></li>`
            });
            modalColor.innerHTML=cl;
        }


       }).catch(err=>console.log(err));
}
