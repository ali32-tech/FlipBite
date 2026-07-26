import React, { useState } from 'react';

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);

  return (
    <div className="flex justify-center w-full fixed top-0 left-0 z-50 font-['Inter']">
      <nav className="mt-[28px] w-[86%] h-[60px] bg-white border border-[#E5E7EB] rounded-[20px] shadow-[0_2px_10px_rgba(0,0,0,0.04)] px-[32px] flex items-center justify-between transition-all duration-300">
        
        {/* Left Section: Logo & Brand */}
        <div className="flex flex-1 items-center gap-[12px]">
          <div className="w-[28px] h-[28px] bg-[#0F172A] rounded-full flex items-center justify-center">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 22L12 2L22 22L12 16L2 22Z" fill="white" />
            </svg>
          </div>
          <span className="text-[#0F172A] font-semibold text-[20px] tracking-tight whitespace-nowrap">
            Vector Search
          </span>
        </div>

        {/* Center Section: Links (Desktop) */}
        <div className="hidden md:flex flex-none items-center gap-[42px]">
          {['Services', 'Method', 'Contact'].map((item) => (
            <a 
              key={item}
              href={`/${item.toLowerCase()}`}
              className="text-[#4B5563] text-[16px] font-medium hover:text-[#111827] transition-colors duration-300 ease-in-out"
            >
              {item}
            </a>
          ))}
        </div>

        {/* Right Section: CTA Button (Desktop) */}
        <div className="hidden md:flex flex-1 items-center justify-end">
          <a 
            href="/contact"
            className="flex items-center gap-[8px] bg-[#0F172A] text-white px-[24px] py-[14px] rounded-[16px] font-medium text-[16px] hover:bg-[#1E293B] hover:-translate-y-[2px] transition-all duration-300 ease-in-out shadow-sm"
          >
            Free Audit
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
            </svg>
          </a>
        </div>

        {/* Mobile Hamburger Icon */}
        <div className="md:hidden flex flex-1 justify-end">
          <button 
            className="text-[#0F172A] focus:outline-none"
            onClick={() => setIsOpen(!isOpen)}
            aria-label="Toggle navigation"
          >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              {isOpen ? (
                <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
              ) : (
                <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
              )}
            </svg>
          </button>
        </div>

      </nav>

      {/* Mobile Menu Dropdown */}
      <div 
        className={`absolute top-[100px] w-[86%] bg-white border border-[#E5E7EB] rounded-[20px] shadow-lg flex flex-col md:hidden overflow-hidden transition-all duration-300 origin-top ${
          isOpen ? 'opacity-100 scale-y-100 visible' : 'opacity-0 scale-y-95 invisible'
        }`}
      >
        <div className="p-[24px] flex flex-col gap-[24px]">
          {['Services', 'Method', 'Contact'].map((item) => (
            <a 
              key={item}
              href={`/${item.toLowerCase()}`}
              className="text-[#4B5563] text-[16px] font-medium hover:text-[#111827] transition-colors duration-300"
            >
              {item}
            </a>
          ))}
          <a 
            href="/contact"
            className="flex items-center justify-center gap-[8px] bg-[#0F172A] text-white px-[24px] py-[14px] rounded-[16px] font-medium text-[16px] hover:bg-[#1E293B] transition-colors duration-300"
          >
            Free Audit
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  );
};

export default Navbar;
