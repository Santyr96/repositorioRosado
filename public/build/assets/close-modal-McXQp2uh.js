const s=new WeakMap;document.addEventListener("DOMContentLoaded",function(){c()});function c(){const n=document.getElementById("errorModal"),o=document.querySelector(".advise-modal");document.querySelectorAll("[data-modal-hide]").forEach(e=>{const t=s.get(e);t&&e.removeEventListener("click",t);const d=()=>{n.classList.add("hidden"),o&&o.classList.add("hidden")};e.addEventListener("click",d),s.set(e,d)})}export{c};
