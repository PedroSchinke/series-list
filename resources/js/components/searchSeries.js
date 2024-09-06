// document.addEventListener('DOMContentLoaded', function() {
//     let typingTimer;
//     let timer;

//     document.getElementById('seriesSearch').addEventListener('input', async function() {
//         clearTimeout(typingTimer);
//         clearTimeout(timer);

//         const seriesName = this.value;

//         typingTimer = setTimeout(function() {
//             fetch(`${seriesIndexUrl}?name=${seriesName}`, {
//                 headers: {
//                     'X-Requested-With': 'XMLHttpRequest'
//                 }
//             })
//             .then(response => response.json())
//             .then(series => {
//                 console.log('requisição');
//                 const seriesList = document.getElementById('series-list');
//                 seriesList.innerHTML = '';
//                 console.log(series);

//                 if (series['data'].length > 0) {
//                     series['data'].forEach(series => {
//                         let seriesItem = `
//                             <li 
//                                 id="series"
//                                 class="d-flex justify-content-between align-items-center p-0" 
//                                 style="height: 60px; box-shadow: 0px 0px 3px 1px #252525; border-radius: 10px; padding: 7px 12px; cursor: pointer;"
//                             >
//                                 <a href="/series/${series.id}/seasons" class="text-decoration-none text-light w-100">
//                                     <div class="d-flex gap-2 align-items-center">
//                                         <img 
//                                             src="${series.cover}" 
//                                             alt="${series.name} cover"
//                                             style="width: 100px; height: 60px; object-fit: cover; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"
//                                         >
//                                         ${series.name}
//                                     </div>
//                                 </a>
//                             </li>
//                         `;

//                         // if (isAuthenticated) {
//                         //     console.log(isAuthenticated);
//                         //     let seriesButtons = `
//                         //         <div id="series-buttons" class="d-flex gap-2 align-items-center h-100" style="display: none;">
//                         //             <a 
//                         //                 href="/series/${series.id}/edit"
//                         //                 class="btn btn-sm d-flex align-items-center"
//                         //                 style="width: 1.2rem; background-color: transparent; padding: 0;"
//                         //             >
//                         //                 <i class='bx bxs-pencil bx-xs series-icon-button' title="Edit"></i>
//                         //             </a>
                        
//                         //             <form action="/series/${series.id}" method="POST" style="width: fit-content; height: fit-content;">
//                         //                 ${csrfToken}
//                         //                 <button 
//                         //                     class="btn btn-sm d-flex justify-content-center align-items-center p-0" 
//                         //                     style="width: 1.2rem; height: 1.2rem; background-color: transparent;"
//                         //                 >
//                         //                     <i class='bx bxs-trash-alt bx-xs series-icon-button' title="Delete"></i>
//                         //                 </button>
//                         //             </form>

//                         //             <a 
//                         //                 href="/seasons/${series.id}"
//                         //                 class="d-flex align-items-center justify-content-center h-100 bg-primary text-decoration-none"  
//                         //                 style="width: 20px;border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
//                         //             >
//                         //                 <i class='bx bxs-chevron-right text-secondary' ></i>
//                         //             </a>
//                         //         </div>
//                         //     `;
//                         //     seriesItem.innerHTML += seriesButtons;
//                         // }
//                         seriesList.innerHTML += seriesItem;
//                     })
                    
//                     let seriesNavBar = document.getElementById('series-nav-bar');
//                         seriesNavBar.innerHTML = '';

//                         seriesNavBar.innerHTML = `
//                             <a href="${series.prev_page_url}" class="btn text-decoration-none">
//                                 <i class='bx bxs-left-arrow text-primary'></i>
//                             </a>
//                             <div class="d-flex gap-2">
//                                 ${Array.from({ length: lastPage }, (_, i) => i + 1).map(i => `
//                                     <a href="${seriesIndexUrl}?page=${i}" class="text-primary ${i === currentPage ? 'font-weight-bold' : ''}">
//                                         ${i}
//                                     </a>
//                                 `).join('')}
//                             </div>
//                             <a href="${series.next_page_url}" class="btn text-decoration-none">
//                                 <i class='bx bxs-right-arrow text-primary'></i>
//                             </a>
//                         `;
//                 } else {
//                     const noResultsMessage = `
//                         <div class="d-flex justify-content-center mt-4">
//                             <p class="text-light">No series with the name '${seriesName}' were found</p>
//                         </div>
//                     `;
//                     seriesList.innerHTML = noResultsMessage;
//                 }
//             })
//             .catch(error => console.log('Error:', error));
//         }, 1000)

//         timer = setTimeout(function() {
//             if (isAuthenticated) {
//                 console.log(series);
//                 console.log(isAuthenticated);
//                 let seriesListItem = document.querySelectorAll('#series');
            
//                 seriesListItem.forEach(series => {
//                     console.log('oi');
//                     series.innerHTML += `
//                         <div id="series-buttons" class="d-flex gap-2 align-items-center h-100" style="display: none;">
//                             <a 
//                                 href="/series/edit"
//                                 class="btn btn-sm d-flex align-items-center"
//                                 style="width: 1.2rem; background-color: transparent; padding: 0;"
//                             >
//                                 <i class='bx bxs-pencil bx-xs series-icon-button' title="Edit"></i>
//                             </a>
                
//                             <form action="/series/" method="POST" style="width: fit-content; height: fit-content;">
                                
//                                 <button 
//                                     class="btn btn-sm d-flex justify-content-center align-items-center p-0" 
//                                     style="width: 1.2rem; height: 1.2rem; background-color: transparent;"
//                                 >
//                                     <i class='bx bxs-trash-alt bx-xs series-icon-button' title="Delete"></i>
//                                 </button>
//                             </form>
            
//                             <a 
//                                 href="/seasons/"
//                                 class="d-flex align-items-center justify-content-center h-100 bg-primary text-decoration-none"  
//                                 style="width: 20px;border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
//                             >
//                                 <i class='bx bxs-chevron-right text-secondary' ></i>
//                             </a>
//                         </div>
//                     `;
//                 })
//             }
//         }, 2000)
//     })
// })
