async function getData() {
    try {
        let searchParams = new URLSearchParams(document.location.search);
        let page = searchParams.get("page") ? searchParams.get("page") : 1 ;
        let sort = searchParams.get("sort") ? searchParams.get("sort") : 'title-ASC';
        const result = await fetch(`http://lovelybakery.loc/category/getProductsJSON?page=${page}&sort=${sort}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        let data =  await result.json();
        return data;

    } catch(error) {
        console.log(error);
    }
}

async function renderPage() {
    let products = await getData();
    let container = document.getElementById('productContainer');
    let product = '';
    products.forEach(item => {
        product += `<div class="col-lg-4 col-md-4 col-sm-12 pb-5">
                        <div class="card h-100">
                            <img src="${item.image}" class="card-img-top" alt="...">
                            <div class="card-body text-center">
                                <h5 class="">${item.title}</h5>
                                <p>Цена : <b>${item.price} грн. / кг</b> </p>
                                <p class=""> <i>${item.description}</i></p>
                            </div>
                            <div class="card-footer text-center">
                                <a class="add-to-cart" data-id="${item.id}" href="/cart/add/${item.id}" style="text-decoration: none">
                                    <button class="btn btn-success">Заказать</button>
                                </a>
                                <a href="/product/view/${item.id}" style="text-decoration: none">
                                    <button class="btn btn-info">Подробнее</button>
                                </a>
                            </div>
                        </div>
                    </div>`;
    });
    container.innerHTML = product;
}

renderPage();