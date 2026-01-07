 <form
     wire:submit.prevent="applySearch"
     class="justify-start join flex mb-2"
 >

     <label class="input rounded  w-full">
         <svg
             class="h-[1em] opacity-50"
             xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
         >
             <g
                 stroke-linejoin="round"
                 stroke-linecap="round"
                 stroke-width="2.5"
                 fill="none"
                 stroke="currentColor"
             >
                 <circle
                     cx="11"
                     cy="11"
                     r="8"
                 ></circle>
                 <path d="m21 21-4.3-4.3"></path>
             </g>
         </svg>
         <input
             type="text"
             wire:model="search"
             class="grow "
             placeholder="Search by caption..."
             maxlength="20"
         />
         <kbd class="kbd kbd-sm">Enter</kbd>
     </label>
 </form>
