import os
import glob

NAVBAR_OLD = '''          <div class="relative w-[28px] h-[28px] bg-[#111827] rounded-[8px] flex items-center justify-center overflow-hidden shrink-0 group">
            <div class="absolute inset-0 bg-gradient-to-br from-[#10B981] to-[#3B82F6] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <svg class="relative z-10 w-[14px] h-[14px] text-white animate-[pulse_2s_infinite]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation: pulseGlow 2s infinite alternate;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
          </div>'''

NAVBAR_NEW = '''          <div class="w-[32px] h-[32px] flex items-center justify-center shrink-0">
             <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full drop-shadow-[0_4px_10px_rgba(16,185,129,0.2)]">
               <path d="M20 4L36 20L20 36L4 20L20 4Z" fill="url(#brandGrad1)" fill-opacity="0.15" stroke="url(#brandGrad1)" stroke-width="3" stroke-linejoin="round" class="animate-pulse"/>
               <path d="M12 20L20 12L28 20" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
               <path d="M16 24L20 20L24 24" stroke="#3B82F6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
               <circle cx="20" cy="20" r="2" fill="#10B981"/>
               <defs>
                 <linearGradient id="brandGrad1" x1="4" y1="4" x2="36" y2="36" gradientUnits="userSpaceOnUse">
                   <stop stop-color="#10B981"/>
                   <stop offset="1" stop-color="#3B82F6"/>
                 </linearGradient>
               </defs>
             </svg>
          </div>'''

FOOTER_OLD = '''            <div class="relative w-[24px] h-[24px] bg-[#111827] rounded-[6px] flex items-center justify-center overflow-hidden shrink-0 group">
              <div class="absolute inset-0 bg-gradient-to-br from-[#10B981] to-[#3B82F6] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              <svg class="relative z-10 w-[12px] h-[12px] text-white animate-[pulse_2s_infinite]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation: pulseGlow 2s infinite alternate;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>'''

FOOTER_NEW = '''            <div class="w-[28px] h-[28px] flex items-center justify-center shrink-0">
               <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full drop-shadow-[0_4px_10px_rgba(16,185,129,0.2)]">
                 <path d="M20 4L36 20L20 36L4 20L20 4Z" fill="url(#brandGrad2)" fill-opacity="0.15" stroke="url(#brandGrad2)" stroke-width="3" stroke-linejoin="round" class="animate-pulse"/>
                 <path d="M12 20L20 12L28 20" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                 <path d="M16 24L20 20L24 24" stroke="#3B82F6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                 <circle cx="20" cy="20" r="2" fill="#10B981"/>
                 <defs>
                   <linearGradient id="brandGrad2" x1="4" y1="4" x2="36" y2="36" gradientUnits="userSpaceOnUse">
                     <stop stop-color="#10B981"/>
                     <stop offset="1" stop-color="#3B82F6"/>
                   </linearGradient>
                 </defs>
               </svg>
            </div>'''

def replace_logos():
    for filepath in glob.glob('d:/sdss/*.html'):
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
            
        content = content.replace(NAVBAR_OLD, NAVBAR_NEW)
        content = content.replace(FOOTER_OLD, FOOTER_NEW)
        
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
            
    print("New premium logos applied.")

if __name__ == '__main__':
    replace_logos()
