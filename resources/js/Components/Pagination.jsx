import React from 'react';

export default function Pagination({ currentPage, totalPages, onPageChange, totalItems, itemsPerPage }) {
    if (totalPages <= 1) return null;

    const getPages = () => {
        const pages = [];
        for (let i = 1; i <= totalPages; i++) {
            if (
                i === 1 || 
                i === totalPages || 
                (i >= currentPage - 1 && i <= currentPage + 1)
            ) {
                pages.push(i);
            } else if (pages[pages.length - 1] !== '...') {
                pages.push('...');
            }
        }
        return pages;
    };

    return (
        <div className="flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t border-black/5 mt-10">
            <p className="text-xs font-black text-[#64748b] uppercase tracking-widest">
                Menampilkan <span className="text-[#0f172a]">{Math.min((currentPage - 1) * itemsPerPage + 1, totalItems)}</span> - <span className="text-[#0f172a]">{Math.min(currentPage * itemsPerPage, totalItems)}</span> dari <span className="text-[#0f172a]">{totalItems}</span> data
            </p>

            <div className="flex items-center gap-2">
                <button 
                    onClick={() => onPageChange(currentPage - 1)}
                    disabled={currentPage === 1}
                    className="w-10 h-10 rounded-xl bg-white border border-black/5 flex items-center justify-center text-[#64748b] hover:border-[#2563eb] hover:text-[#2563eb] disabled:opacity-30 disabled:hover:border-black/5 disabled:hover:text-[#64748b] transition-all shadow-sm"
                >
                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M15 19l-7-7 7-7" /></svg>
                </button>

                <div className="flex items-center gap-1.5">
                    {getPages().map((page, index) => (
                        page === '...' ? (
                            <span key={index} className="w-10 h-10 flex items-center justify-center text-[#64748b] font-black text-sm">...</span>
                        ) : (
                            <button
                                key={index}
                                onClick={() => onPageChange(page)}
                                className={`w-10 h-10 rounded-xl font-black text-sm transition-all shadow-sm ${
                                    currentPage === page 
                                    ? 'bg-[#2563eb] text-white shadow-lg shadow-blue-100' 
                                    : 'bg-white border border-black/5 text-[#64748b] hover:border-[#2563eb] hover:text-[#2563eb]'
                                }`}
                            >
                                {page}
                            </button>
                        )
                    ))}
                </div>

                <button 
                    onClick={() => onPageChange(currentPage + 1)}
                    disabled={currentPage === totalPages}
                    className="w-10 h-10 rounded-xl bg-white border border-black/5 flex items-center justify-center text-[#64748b] hover:border-[#2563eb] hover:text-[#2563eb] disabled:opacity-30 disabled:hover:border-black/5 disabled:hover:text-[#64748b] transition-all shadow-sm"
                >
                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3"><path d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>
    );
}
