import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';

// Kita akan mendaftarkan komponen-komponen React di sini
// Contoh: Leaderboard, VotingCard, dll.

const components = {
    // 'leaderboard-root': Leaderboard,
};

document.addEventListener('DOMContentLoaded', () => {
    Object.entries(components).forEach(([id, Component]) => {
        const el = document.getElementById(id);
        if (el) {
            const root = createRoot(el);
            root.render(<Component {...el.dataset} />);
        }
    });
    
    // Testing integration
    const testEl = document.getElementById('react-test');
    if (testEl) {
        const root = createRoot(testEl);
        root.render(<div className="p-4 bg-blue-100 text-blue-800 rounded-xl font-bold">React Terintegrasi! 🚀</div>);
    }
});
