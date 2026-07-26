import os
import glob
import re

NAVBAR_OLD = '''          <div class="w-[28px] h-[28px] bg-[#111827] rounded-full flex items-center justify-center">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 22L12 2L22 22L12 16L2 22Z" fill="currentColor" /></svg>
          </div>'''

NAVBAR_NEW = '''          <div class="relative w-[28px] h-[28px] bg-[#111827] rounded-[8px] flex items-center justify-center overflow-hidden shrink-0 group">
            <div class="absolute inset-0 bg-gradient-to-br from-[#10B981] to-[#3B82F6] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <svg class="relative z-10 w-[14px] h-[14px] text-white animate-[pulse_2s_infinite]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation: pulseGlow 2s infinite alternate;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
          </div>'''

FOOTER_OLD = '''            <div class="w-[24px] h-[24px] bg-[#111827] rounded-full flex items-center justify-center">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 22L12 2L22 22L12 16L2 22Z" fill="currentColor" /></svg>
            </div>'''

FOOTER_NEW = '''            <div class="relative w-[24px] h-[24px] bg-[#111827] rounded-[6px] flex items-center justify-center overflow-hidden shrink-0 group">
              <div class="absolute inset-0 bg-gradient-to-br from-[#10B981] to-[#3B82F6] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              <svg class="relative z-10 w-[12px] h-[12px] text-white animate-[pulse_2s_infinite]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation: pulseGlow 2s infinite alternate;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>'''

def replace_logos():
    for filepath in glob.glob('d:/sdss/*.html'):
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
            
        content = content.replace(NAVBAR_OLD, NAVBAR_NEW)
        content = content.replace(FOOTER_OLD, FOOTER_NEW)
        
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
            
    print("Logos successfully updated.")

replace_logos()
