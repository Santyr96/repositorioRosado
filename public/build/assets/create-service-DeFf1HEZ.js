import{c as y}from"./close-modal-McXQp2uh.js";function M(a){const o=document.getElementById("create"),e=document.querySelector(".advise-modal"),r=document.getElementById("child"),t=document.getElementById("modalTitle"),n=document.getElementById("message"),s=document.getElementById("idHairdresser");o.addEventListener("click",function(){e.classList.contains("hidden")&&(C(e,r,t,n),I(e,a,s),e.classList.toggle("hidden"))})}function C(a,o,e,r){const t=a.children[0].children[0];t.classList.replace("bg-gray-600","bg-purple-700"),t.children[0].classList.add("bg-white"),a.id="createModal",o.replaceChildren(),o.insertAdjacentHTML("afterbegin",F()),e.textContent="Creación de servicio",e.classList.replace("text-white","text-black"),r.textContent="¿Quieres crear un servicio?"}function F(){return`
        <form class="flex flex-col justify-center gap-2" name="fcreateService" data-form="" method="post">
            <label class="text-white" for="name">Nombre para el servicio</label>
            <input type="text" name="name" id="name" value="">
            <x-forms.span-validate class="w-10/12"></x-forms.span-validate>

            <label class="text-white"  for="description">Descripción</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
            <x-forms.span-validate class="w-10/12"></x-forms.span-validate>

            <label class="text-white" for="price">Precio</label>
            <input class="w-16 p-1 text-sm resize-none" step="0.50" type="number" name="price" value=""
                min="0" placeholder="0.00"
                oninput="this.value = (this.value && !isNaN(this.value)) ? parseFloat(this.value).toFixed(2) : ''">

            <div class="flex justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button id="send" data-modal-hide="createModal" type="submit" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Crear servicio
                </button>
                <button id="cancel" type="button"
                data-modal-hide="createModal"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Cancelar
                </button>
            </div>
        </form>
    `}function I(a,o,e){const r=document.forms.fcreateService;r.addEventListener("submit",async function(t){t.preventDefault();const s=document.getElementById("create").getAttribute("data-form"),i=new FormData(r);i.append(e.name,e.value);try{await T(s,i,o),a.classList.add("hidden")}catch(b){a.classList.add("hidden"),d(b.message||"Ocurrió un error al crear el servicio. Inténtalo nuevamente.","Error al crear el servicio")}})}async function T(a,o,e){const r=await fetch(a,{method:"POST",headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:o});if(r.ok)await v(e);else{const t=await r.json();throw new Error(`Error en la solicitud: ${t.error}`)}}function A(a){const o=document.querySelectorAll(".deleteForm"),e=document.getElementById("confirmation"),r=document.getElementById("deleteWarning");e.addEventListener("click",async function(){const t=this.getAttribute("data-delete");if(!t){d("URL de eliminación no disponible.");return}try{const n=await fetch(t,{method:"POST",headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")}});if(!n.ok){const s=await n.json();throw new Error(`Error en la solicitud: ${s.error}`)}await v(a)}catch(n){console.error("Error:",n),d(n.message||"Ocurrió un error al eliminar el servicio. Intenta nuevamente.")}}),o.forEach(t=>{t.addEventListener("submit",function(n){n.preventDefault();const s=this.getAttribute("data-form");if(!s){console.error("La URL para eliminar un servicio no está disponible."),d("Error interno. Intenta más tarde.");return}e.setAttribute("data-delete",s),r.classList.contains("hidden")&&r.classList.toggle("hidden")})}),y()}function B(a){const o=document.querySelectorAll(".updateForm"),e=document.querySelector(".advise-modal"),r=document.getElementById("child"),t=document.getElementById("modalTitle"),n=document.getElementById("message");function s(l,u,p){e.classList.contains("hidden")&&(e.children[0].children[0].classList.replace("bg-gray-600","bg-purple-700"),e.children[0].children[0].children[0].classList.add("bg-white"),e.id="updateModal",r.replaceChildren(),r.insertAdjacentHTML("afterbegin",b()),t.textContent="Actualización de servicio",t.classList.replace("text-white","text-black"),n.textContent="¿Quieres actualizar este servicio?",k(l,u),i()),e.classList.toggle("hidden")}function i(){y()}function b(){return`
            <form class="flex flex-col justify-center gap-2" name="fupdateServiceModal" data-form="" method="post">
                <label class="text-white" for="name">Nombre para el servicio</label>
                <input type="text" name="name" id="name" value="">
                <x-forms.span-validate class="w-10/12"></x-forms.span-validate>

                <label class="text-white" for="description">Descripción</label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
                <x-forms.span-validate class="w-10/12"></x-forms.span-validate>

                <label class="text-white" for="price">Precio</label>
                <input class="w-16 p-1 text-sm resize-none" step="0.50" type="number" name="price" value=""
                    min="0" placeholder="0.00"
                    oninput="this.value = (this.value && !isNaN(this.value)) ? parseFloat(this.value).toFixed(2) : ''">

                <div class="flex justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="send" type="submit" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" data-modal-hide="updateModal">
                        Editar servicio
                    </button>
                    <button id="cancel" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" data-modal-hide="updateModal">
                        Cancelar
                    </button>
                </div>
            </form>
        `}function k(l,u){const p=l.querySelectorAll("td"),c=new Map;p.forEach(h=>{c.set(h.id,h.textContent.trim())});const m=document.forms.fupdateServiceModal;m.setAttribute("data-form",u),m.name.value=c.get("tdName"),m.description.value=c.get("tdDescription");const x=parseFloat(String(c.get("tdPrice")).replace(/\s+/g,"").replace("€",""));let g=x.toFixed(2);g.endsWith(".00")?g=".00":g.endsWith("0")&&(g="0"),m.price.value=x+g,m.addEventListener("submit",async function(h){h.preventDefault();const S=new FormData(this);try{const f=await fetch(u,{method:"POST",headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:S});if(!f.ok){const L=await f.json();throw new Error(`Error en la solicitud: ${L.error}`)}await v(a)}catch(f){console.error("Error:",f),d(f.message||"Ocurrió un error al actualizar el servicio. Inténtalo nuevamente.","Error al actualizar el servicio")}})}o.forEach(l=>{const u=l.parentElement.parentElement;l.addEventListener("submit",function(p){p.preventDefault();const c=this.getAttribute("data-form");if(!c){console.error("La URL para actualizar un servicio no está disponible."),d("Error interno. Intenta más tarde.");return}s(u,c)})})}let w;function q(){const a=document.getElementById("content");document.forms.fSelectHairdresser.addEventListener("submit",async function(e){e.preventDefault();const r=this.getAttribute("data-select_services");try{const t=new FormData(this);if(w=t.get("hairdresser_id"),!t.has("hairdresser_id")||t.get("hairdresser_id")==="")throw new Error("No se ha seleccionado ninguna peluquería");const n=await fetch(r,{method:"POST",headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:t});if(!n.ok){const i=await n.json();throw console.log(i),new Error(`${i.error}`)}const s=await n.text();a.innerHTML=s,E()}catch(t){console.error("Error al cargar el contenido",t),d(t)}})}function E(){const a=document.getElementById("serviceTable").getAttribute("data-url");M(a),A(a),B(a)}function d(a,o){const e=document.getElementById("errorModal"),r=e.querySelector("p"),t=e.querySelector("h3");t&&(t.textContent=o),r&&(r.textContent=a),e&&e.classList.toggle("hidden"),y()}async function v(a){const o=document.getElementById("content"),e=new FormData;e.append("hairdresser_id",w);try{const r=await fetch(a,{method:"POST",headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:e});if(!r.ok)throw console.error("Error en la solicitud"),new Error("Error en la solicitud");const t=await r.text();o.innerHTML=t,E()}catch(r){console.error("Error al cargar el contenido",r),o.innerText="Error al cargar el contenido."}}export{d as a,A as d,v as r,q as s,B as u};
