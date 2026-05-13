import React, { useEffect, useState } from 'react';

export default function Toast({ message, type = 'success', duration = 3000, onClose }) {
    const [progress, setProgress] = useState(100);

    useEffect(() => {
        const interval = 10;
        const step = (interval / duration) * 100;
        
        const timer = setInterval(() => {
            setProgress((prev) => {
                if (prev <= 0) {
                    clearInterval(timer);
                    return 0;
                }
                return prev - step;
            });
        }, interval);

        const closeTimer = setTimeout(() => {
            onClose();
        }, duration);

        return () => {
            clearInterval(timer);
            clearTimeout(closeTimer);
        };
    }, [duration, onClose]);

    const icons = {
        success: (
            <div className="w-8 h-8 bg-green-100 text-green-600 rounded-xl flex items-center justify-center shrink-0">
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" /></svg>
            </div>
        ),
        error: (
            <div className="w-8 h-8 bg-red-100 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </div>
        )
    };

    return (
        <div className="fixed top-6 right-6 z-[9999] animate-in slide-in-from-right duration-500">
            <div className="bg-white border border-black/5 shadow-2xl rounded-[1.5rem] p-4 pr-10 min-w-[300px] relative overflow-hidden flex items-center gap-4">
                {icons[type]}
                <div className="flex flex-col">
                    <span className="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Notifikasi</span>
                    <p className="text-sm font-bold text-slate-800 leading-tight">{message}</p>
                </div>

                <button 
                    onClick={onClose}
                    className="absolute top-4 right-4 text-slate-300 hover:text-slate-500 transition-colors"
                >
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                {/* Progress Bar */}
                <div className="absolute bottom-0 left-0 h-1 bg-slate-100 w-full">
                    <div 
                        className={`h-full transition-all linear ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`}
                        style={{ width: `${progress}%` }}
                    />
                </div>
            </div>
        </div>
    );
}
