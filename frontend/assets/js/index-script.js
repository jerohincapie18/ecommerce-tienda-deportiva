const ulStoreGrid = document.getElementById("ulStoreGrid");
const btnShowMore = document.getElementById("showMore");

btnShowMore.addEventListener("click", showMore);

function showMore() // usara prevent default con una query?? 
{
    for(i=0; i<10; i++)
    {
        //cuando se escale, se puede usar un arreglo para rescatar, img, nombre y precio
        ulStoreGrid.insertAdjacentHTML("beforeend", 
            `
                <li> 
                    <article class="store-article">
                        <img src="./assets/profilepic.png" alt="">
                        <div class="article-info">
                            <div class="article-text">
                                <div>Nombre</div>
                                <div>Precio</div>
                            </div>
                            <button>favorito</button>
                        </div>
                    </article>
                </li>
            `
        );
    }
}
