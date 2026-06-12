export default {
    isDark: localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

    toggle() {
        this.isDark = !this.isDark;
        localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.isDark);
    },

    setLight() {
        this.isDark = false;
        localStorage.setItem('theme', 'light');
        document.documentElement.classList.remove('dark');
    },

    setDark() {
        this.isDark = true;
        localStorage.setItem('theme', 'dark');
        document.documentElement.classList.add('dark');
    }
};
