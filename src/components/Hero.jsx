import React from 'react';
import { motion } from 'framer-motion';
import Navbar from './Navbar';

const Hero = () => {
  return (
    <div className="relative min-h-screen bg-[#F7F8F5] flex flex-col items-center overflow-hidden font-['Inter']">
      
      {/* Background Ambient Glows */}
      <div className="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[1000px] h-[500px] bg-white rounded-full blur-[100px] opacity-80 pointer-events-none"></div>
      <div className="absolute bottom-[-10%] left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-[#A7F3D0] rounded-full blur-[150px] opacity-30 pointer-events-none"></div>

      {/* Navbar Integration */}
      <Navbar />

      {/* Main Content */}
      <div className="flex-1 flex flex-col items-center justify-center pt-[160px] md:pt-[200px] pb-[60px] px-4 w-full max-w-5xl z-10 relative">
        
        {/* Badge */}
        <motion.div 
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, ease: "easeOut" }}
          className="bg-[#E6F8F0] border border-[#D1F0E0] text-[#059669] px-[16px] py-[6px] rounded-full text-[11px] font-bold tracking-[0.08em] mb-[32px] uppercase shadow-sm"
        >
          Data-Driven Visibility
        </motion.div>

        {/* Heading */}
        <motion.h1 
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.1, ease: "easeOut" }}
          className="text-[#0F172A] text-[52px] sm:text-[64px] md:text-[76px] font-bold leading-[1.05] tracking-[-0.03em] text-center max-w-[850px] mb-[32px]"
        >
          High-precision<br />
          SEO architecture<br />
          for modern growth
        </motion.h1>

        {/* Subtext */}
        <motion.p 
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.2, ease: "easeOut" }}
          className="text-[#64748B] text-[18px] sm:text-[20px] md:text-[22px] leading-[1.6] text-center max-w-[720px] mb-[72px]"
        >
          We combine technical infrastructure optimization with semantic content mapping to secure durable authority in evolving search landscapes.
        </motion.p>

      </div>

      {/* Bottom Visual Section */}
      <motion.div 
        initial={{ opacity: 0, y: 80 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.8, delay: 0.3, ease: [0.16, 1, 0.3, 1] }}
        className="w-full max-w-[1000px] h-[350px] relative z-10 mx-auto px-4 sm:px-8 mt-auto"
      >
        {/* The Dashboard Glass Card */}
        <div className="w-full h-full bg-gradient-to-b from-[#F0FDF4]/80 to-[#F7F8F5]/20 backdrop-blur-md border-[1.5px] border-white rounded-t-[36px] shadow-[0_-10px_40px_rgba(16,185,129,0.06)] relative overflow-hidden flex justify-center pt-[20px]">
          
          {/* Inner glowing panel */}
          <div className="w-[92%] h-full bg-gradient-to-b from-[#A7F3D0]/60 to-[#F7F8F5]/10 rounded-t-[28px] border-[1.5px] border-white/80 shadow-inner relative overflow-hidden">
            <div className="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white to-transparent opacity-80"></div>
          </div>
        </div>

        {/* Floating Analytics Card */}
        <motion.div 
          animate={{ y: [0, -12, 0] }}
          transition={{ repeat: Infinity, duration: 4.5, ease: "easeInOut" }}
          className="absolute right-[10%] md:right-[5%] top-[-30px] bg-white rounded-[24px] p-[20px] pr-[32px] shadow-[0_20px_40px_rgba(0,0,0,0.06)] border border-[#F1F5F9] flex gap-[16px] items-center z-20"
        >
          {/* Arrow Icon Circle */}
          <div className="w-[44px] h-[44px] rounded-full bg-[#ECFDF5] flex items-center justify-center text-[#059669]">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
              <path d="M23 6l-9.5 9.5-5-5L1 18"/>
              <path d="M17 6h6v6"/>
            </svg>
          </div>
          
          {/* Text and Line */}
          <div className="flex flex-col gap-[2px]">
            <div className="text-[#64748B] text-[11px] font-bold uppercase tracking-[0.1em]">Visibility</div>
            <div className="text-[#0F172A] text-[22px] font-extrabold tracking-tight">+142%</div>
            {/* Green thick line at bottom of the text */}
            <div className="w-full h-[4px] bg-[#10B981] rounded-full mt-[6px]"></div>
          </div>
        </motion.div>
      </motion.div>

    </div>
  );
};

export default Hero;
