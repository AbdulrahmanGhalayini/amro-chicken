<!DOCTYPE html>
<!-- HTML tag uses dir attribute for RTL support -->
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO & Open Graph Tags -->
    <title data-i18n="title">QREXE | Create Your Digital QR Menu</title>
    <meta name="description" content="Digitize Your Restaurant With QREXE Menu. Create digital QR menus for your restaurant or coffee shop instantly.">
    <meta property="og:title" content="QREXE | Create Your Digital QR Menu">
    <meta property="og:description" content="Digitize Your Restaurant With QREXE Menu. Fast, responsive, and easy to use.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://qr.algorexe.com">
    <!-- Replace with actual OG image URL -->
    <meta property="og:image" content="https://qr.algorexe.com/assets/images/og-image.jpg">
    
    <!-- Preconnect to Google Fonts for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    {{-- <link rel="stylesheet" href="styles.css"> --}}
    <style>
        /* 
    QREXE Modern SaaS Landing Page
    Author: Antigravity
    Description: CSS for the QREXE web app, mobile-first and responsive.
*/

/* =========================================
   CSS Variables
   ========================================= */
:root {
    /* Brand Colors */
    --primary-color: #3C9BCF;       /* Brand Blue */
    --primary-hover: #2b7eb1;       /* Darker Blue */
    --primary-light: #e6f3fa;       /* Very Light Blue */
    --secondary-color: #8C81BE;     /* Brand Purple */
    --secondary-hover: #7b70ab;     /* Darker Purple */
    --accent-color: #BEBEC2;        /* Brand Gray */
    
    /* Backgrounds & Surfaces (Dark Theme based on #373251) */
    --bg-main: #373251;             /* The requested background */
    --bg-light: #2c2842;            /* Darker shade for contrast */
    --bg-card: #453f65;             /* Lighter shade for cards */
    
    /* Text Colors */
    --text-main: #ffffff;           /* Changed text to white for dark mode */
    --text-muted: var(--accent-color); /* The #BEBEC2 gray works perfectly */
    --text-light: #ffffff;
    
    /* UI Elements */
    --border-color: #554e7d;        /* Adjusted border for dark mode */
    --radius-sm: 0.5rem;
    --radius-md: 1rem;
    --radius-lg: 1.5rem;
    --radius-pill: 9999px;
    
    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-hover: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    
    /* Typography */
    --font-family: 'Inter', system-ui, -apple-system, sans-serif;
    --transition-fast: 0.2s ease;
    --transition-normal: 0.3s ease;
}

/* =========================================
   Reset & Base Styles
   ========================================= */
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html {
    scroll-behavior: smooth;
    font-size: 16px;
}

body {
    font-family: var(--font-family);
    background-color: var(--bg-main);
    color: var(--text-main);
    line-height: 1.6;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}

img, picture, svg, video {
    display: block;
    max-width: 100%;
    height: auto;
}

a {
    text-decoration: none;
    color: inherit;
    transition: color var(--transition-fast);
}

ul {
    list-style: none;
}

h1, h2, h3, h4, h5, h6 {
    color: var(--secondary-color);
    line-height: 1.2;
    font-weight: 700;
}

.padding-block {
    padding-block: 5rem;
}

.bg-light {
    background-color: var(--bg-light);
}

.container {
    width: 100%;
    max-width: 1280px;
    margin: 0 auto;
    padding-inline: 1.5rem;
}

.section-header {
    text-align: center;
    max-width: 600px;
    margin: 0 auto 3rem;
}

.section-header h2 {
    font-size: 2.25rem;
    margin-bottom: 1rem;
    letter-spacing: -0.025em;
}

.section-header p {
    color: var(--text-muted);
    font-size: 1.125rem;
}

/* =========================================
   Buttons
   ========================================= */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: var(--radius-pill);
    cursor: pointer;
    transition: all var(--transition-normal);
    text-align: center;
    border: 2px solid transparent;
}

.btn-primary {
    background-color: var(--primary-color);
    color: var(--text-light);
    box-shadow: var(--shadow-md);
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: var(--text-light);
}

.btn-secondary {
    background-color: var(--bg-main);
    color: var(--secondary-color);
    border-color: var(--border-color);
}

.btn-secondary:hover {
    border-color: var(--secondary-color);
    background-color: var(--bg-light);
}

.btn-light {
    background-color: var(--bg-main);
    color: var(--primary-color);
}

.btn-light:hover {
    background-color: var(--bg-light);
    color: var(--primary-hover);
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.125rem;
}

/* =========================================
   Header & Navbar
   ========================================= */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: rgba(55, 50, 81, 0.9); /* Translucent #373251 */
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    z-index: 1000;
    border-bottom: 1px solid transparent;
    transition: all var(--transition-normal);
    height: 80px;
}

.navbar.scrolled {
    border-bottom: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    height: 70px;
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 100%;
}

.brand-logo {
    display: flex;
    align-items: center;
}

.logo-img {
    height: 35px;
    width: auto;
}

.nav-links {
    display: none; /* Mobile first */
}

.mobile-menu-toggle {
    display: block;
    background: transparent;
    border: none;
    font-size: 2rem;
    color: var(--text-main);
    cursor: pointer;
}

/* Language Toggle */
.lang-toggle-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-main);
    padding: 0.5rem 1rem;
    border-radius: var(--radius-pill);
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.lang-toggle-btn:hover {
    background-color: var(--bg-light);
    color: var(--primary-color);
    border-color: var(--primary-color);
}

/* =========================================
   Hero Section
   ========================================= */
.hero {
    position: relative;
    padding-top: 140px;
    padding-bottom: 60px;
    overflow: hidden;
    background: linear-gradient(135deg, var(--bg-main) 0%, var(--bg-light) 100%);
}

.hero-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3rem;
    align-items: center;
}

.hero-content {
    text-align: center;
    z-index: 2;
}

.badge {
    display: inline-block;
    padding: 0.35rem 1rem;
    background-color: var(--primary-light);
    color: var(--primary-color);
    border-radius: var(--radius-pill);
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    margin-bottom: 1.5rem;
}

.subheadline {
    font-size: 1.125rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
    max-width: 600px;
    margin-inline: auto;
}

.hero-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    justify-content: center;
}

.hero-visual {
    position: relative;
    display: flex;
    justify-content: center;
    perspective: 1000px;
}

/* Mockup */
.phone-mockup {
    width: 280px;
    height: 580px;
    background-color: var(--secondary-color);
    border-radius: 2.5rem;
    padding: 0.75rem;
    box-shadow: var(--shadow-hover);
    transform: rotateY(-10deg) rotateX(5deg);
    transition: transform var(--transition-normal);
}

.phone-mockup:hover {
    transform: rotateY(0deg) rotateX(0deg);
}

.phone-screen {
    width: 100%;
    height: 100%;
    background-color: var(--bg-main);
    border-radius: 1.75rem;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.mockup-header {
    background-color: var(--bg-main);
    padding: 2rem 1rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
}

.mockup-logo {
    height: 20px;
    margin-bottom: 0.5rem;
}

.mockup-logo-text {
    font-weight: 700;
    font-size: 1.1rem;
}

.mockup-body {
    padding: 1.5rem 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.mockup-qr {
    background-color: var(--bg-light);
    border-radius: var(--radius-md);
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--text-main);
    border: 2px dashed var(--border-color);
}

.mockup-qr i {
    font-size: 5rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
}

.mockup-item {
    background-color: var(--bg-light);
    height: 60px;
    border-radius: var(--radius-sm);
    width: 100%;
}

.mockup-item.short {
    width: 70%;
}

.hero-bg-shape {
    position: absolute;
    top: -10%;
    right: -5%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(60,155,207,0.1) 0%, rgba(255,255,255,0) 70%); /* Replaced with #3C9BCF with opacity */
    border-radius: 50%;
    z-index: 0;
}

/* =========================================
   How It Works
   ========================================= */
.steps-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    position: relative;
}

.step-card {
    background: var(--bg-card);
    padding: 2.5rem 2rem;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    text-align: center;
    position: relative;
    border: 1px solid var(--border-color);
    transition: transform var(--transition-normal);
}

.step-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.step-number {
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 40px;
    background-color: var(--primary-color);
    color: var(--text-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.25rem;
    border: 4px solid var(--bg-main);
}

.step-icon {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    margin-top: 1rem;
}

.step-card h3 {
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.step-card p {
    color: var(--text-muted);
}

/* =========================================
   Features
   ========================================= */
.features-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

.feature-card {
    background-color: var(--bg-card);
    padding: 2rem;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    transition: all var(--transition-normal);
}

.feature-card:hover {
    box-shadow: var(--shadow-md);
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.feature-card i {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 1.25rem;
    background-color: rgba(60, 155, 207, 0.15); /* Light blue transparent bg */
    padding: 1rem;
    border-radius: var(--radius-md);
    display: inline-flex;
}

.feature-card h3 {
    margin-bottom: 0.75rem;
    font-size: 1.25rem;
}

.feature-card p {
    color: var(--text-muted);
    font-size: 0.95rem;
}

/* =========================================
   Restaurants Grid (The requested block)
   ========================================= */
.business-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

.business-card {
    background-color: var(--bg-card);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    transition: all var(--transition-normal);
    display: flex;
    flex-direction: column;
}

.business-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-hover);
}

.business-image-wrapper {
    position: relative;
    height: 200px;
    overflow: hidden;
    background-color: var(--bg-light);
}

.business-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-normal);
}

.business-card:hover .business-image {
    transform: scale(1.05);
}

.category-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background-color: var(--bg-main);
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-pill);
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary-color);
    backdrop-filter: blur(4px);
    border: 1px solid var(--border-color);
}

.business-info {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.business-info h3 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.business-info .slogan {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 1.25rem;
    flex: 1;
}

.business-info .category {
    /* Kept for exact blade markup matching if someone extracts inner HTML directly */
    display: none; 
}

.stats {
    display: flex;
    justify-content: space-between;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
    margin-bottom: 1.25rem;
    font-size: 0.875rem;
    color: var(--text-muted);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.view-menu-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.75rem;
    background-color: rgba(60, 155, 207, 0.15); /* Semi transparent primary */
    color: var(--primary-color);
    font-weight: 600;
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.view-menu-btn:hover {
    background-color: var(--primary-color);
    color: var(--text-light);
}

/* =========================================
   Benefits Section
   ========================================= */
.benefits-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

.benefit-item {
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}

.benefit-icon {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    background-color: var(--primary-color);
    color: var(--text-light);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    box-shadow: var(--shadow-md);
}

.benefit-text h4 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.benefit-text p {
    color: var(--text-muted);
}

/* =========================================
   CTA Section
   ========================================= */
.cta-section {
    padding: 6rem 1.5rem;
    background-color: var(--primary-color);
    color: var(--text-light);
    position: relative;
    overflow: hidden;
}

.cta-container {
    text-align: center;
    position: relative;
    z-index: 2;
}

.cta-content h2 {
    color: var(--text-light);
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.cta-content p {
    font-size: 1.25rem;
    margin-bottom: 2.5rem;
    opacity: 0.9;
    max-width: 600px;
    margin-inline: auto;
}

.cta-decoration {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 1000px;
    height: 1000px;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 60%);
    pointer-events: none;
}

/* =========================================
   Footer
   ========================================= */
.footer {
    background-color: var(--bg-light); /* Make footer slightly visually distinct in dark mode */
    color: var(--text-light);
    padding-top: 5rem;
}

.footer-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3rem;
    padding-bottom: 3rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-brand p {
    color: var(--accent-color);
    margin-block: 1.5rem;
    max-width: 300px;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-links a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    font-size: 1.25rem;
}

.social-links a:hover {
    background-color: var(--primary-color);
    transform: translateY(-3px);
}

.footer-links-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.footer-col h4 {
    color: var(--text-light);
    margin-bottom: 1.5rem;
    font-size: 1.125rem;
}

.footer-col ul li {
    margin-bottom: 0.75rem;
}

.footer-col ul a {
    color: var(--accent-color);
}

.footer-col ul a:hover {
    color: var(--text-light);
    padding-left: 5px;
}

.footer-bottom {
    padding-block: 1.5rem;
    text-align: center;
    color: var(--text-main);
    font-size: 0.875rem;
}

/* =========================================
   Utility Classes & Animations
   ========================================= */
.fadeIn {
    animation: fadeIn 0.8s ease-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================================
   Media Queries (Mobile First → Tablet → Desktop)
   ========================================= */

/* Tablet (Small Screens) */
@media (min-width: 768px) {
    .hero {
        padding-top: 160px;
        padding-bottom: 80px;
    }
    
    .hero h1 {
        font-size: 3.5rem;
    }
    
    .hero-buttons {
        flex-direction: row;
    }

    .steps-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .business-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .footer-container {
        grid-template-columns: 1fr 1fr;
    }
}

/* Desktop */
@media (min-width: 1024px) {
    .navbar-container {
        padding-inline: 0;
    }
    
    .mobile-menu-toggle {
        display: none;
    }
    
    .nav-links {
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    
    .nav-links a:not(.btn) {
        font-weight: 500;
    }
    
    .nav-links a:not(.btn):hover {
        color: var(--primary-light); /* Better contrast on dark bg hover */
    }
    
    .hero-container {
        grid-template-columns: 1fr 1fr;
        text-align: left;
    }
    
    .hero-content {
        text-align: left;
        padding-right: 2rem;
    }
    
    .subheadline {
        margin-left: 0;
    }
    
    .hero-buttons {
        justify-content: flex-start;
    }
    
    .features-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .business-grid {
        grid-template-columns: repeat(4, 1fr);
    }
    
    .footer-container {
        grid-template-columns: 2fr 3fr;
    }
}

/* Mobile Nav Styles handled via JS classes */
.nav-active {
    display: flex;
    flex-direction: column;
    position: absolute;
    top: 80px;
    left: 0;
    width: 100%;
    background-color: var(--bg-main);
    box-shadow: var(--shadow-md);
    padding: 2rem;
    gap: 1.5rem;
    border-top: 1px solid var(--border-color);
    animation: slideDown 0.3s ease-out;
}

.nav-active .btn {
    width: 100%;
}

@keyframes slideDown {
    from { max-height: 0; opacity: 0; }
    to { max-height: 400px; opacity: 1; }
}

/* =========================================
   RTL Styles (Arabic)
   ========================================= */
[dir="rtl"] {
    font-family: 'Cairo', 'Tajawal', var(--font-family); /* Popular Arabic Fonts */
}

/* Text Alignments */
[dir="rtl"] .hero-content,
[dir="rtl"] .hero-container {
    text-align: right;
}

/* Fix Hero specific desktop alignment */
@media (min-width: 1024px) {
    [dir="rtl"] .hero-content {
        padding-right: 0;
        padding-left: 2rem;
    }
}

/* Fix icons spacing in buttons */
[dir="rtl"] .lang-toggle-btn,
[dir="rtl"] .btn {
    flex-direction: row-reverse;
}

/* Arrow Directions */
[dir="rtl"] .dir-icon {
    transform: rotate(180deg);
}

/* Margins & Paddings */
[dir="rtl"] .benefit-item {
    text-align: right;
}

[dir="rtl"] .feature-card {
    text-align: right;
}

[dir="rtl"] .business-info {
    text-align: right;
}

[dir="rtl"] .mockup-logo-text {
    direction: ltr; /* keep QREXE LTR if preferred */
}

/* Footer Alignments */
[dir="rtl"] .footer-col {
    text-align: right;
}

[dir="rtl"] .footer-brand p {
    text-align: right;
    margin-right: 0;
    margin-left: auto; /* Justification reset */
}

/* Nav Desktop Specific RTL */
@media (min-width: 1024px) {
    [dir="rtl"] .nav-links {
        flex-direction: row-reverse;
    }
}

/* =========================================
   WhatsApp Floating Button
   ========================================= */
.whatsapp-button {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background-color: #25d366;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    transition: all var(--transition-normal);
    z-index: 999;
    text-decoration: none;
}

.whatsapp-button:hover {
    background-color: #20ba5a;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
}

.whatsapp-button i {
    font-size: 32px;
    color: white;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .whatsapp-button {
        bottom: 20px;
        right: 20px;
        width: 55px;
        height: 55px;
    }
    
    .whatsapp-button i {
        font-size: 28px;
    }
}

    </style>
    
    <!-- Optionally include FontAwesome or BoxIcons if needed, using BoxIcons for lightweight icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Navbar -->
    <header class="navbar" id="navbar">
        <div class="container navbar-container">
            <a href="/" class="brand-logo" aria-label="QREXE Home">
                <!-- Replace src with actual logo from backend -->
                <img src="https://qr.algorexe.com/images/website_images/logo.png" alt="QREXE Logo" class="logo-img" id="nav-logo" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'30\'><text x=\'0\' y=\'20\' font-family=\'Inter\' font-weight=\'bold\' font-size=\'24\' fill=\'%230f172a\'>QREXE</text></svg>'">
            </a>

            <button class="mobile-menu-toggle" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                <i class='bx bx-menu'></i>
            </button>

            <nav id="main-nav" class="nav-links">
                <a href="#how-it-works" data-i18n="nav_how">How It Works</a>
                <a href="#features" data-i18n="nav_features">Features</a>
                <a href="#restaurants" data-i18n="nav_restaurants">Restaurants</a>
                <a href="#benefits" data-i18n="nav_benefits">Benefits</a>
                
                <!-- Language Toggle -->
                <button id="lang-toggle" class="lang-toggle-btn" aria-label="Toggle Language">
                    <i class='bx bx-globe'></i> <span class="lang-text">AR</span>
                </button>
                
                <a href="/admin" class="nav-link-login" data-i18n="nav_login">Login</a>
                <a href="https://wa.me/96170579786" class="btn btn-primary cta-nav" data-i18n="nav_cta">Create Menu</a>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero" id="hero">
            <div class="container hero-container">
                <div class="hero-content">
                    <span class="badge" data-i18n="hero_badge">Modernize Your Business</span>
                    <h1 data-i18n="hero_title">Create a Digital QR Menu for Your Restaurant</h1>
                    <p class="subheadline" data-i18n="hero_subtitle">Let customers scan your QR code and browse your menu instantly. Fast, completely contactless, and always up-to-date.</p>
                    <div class="hero-buttons">
                        <a href="https://wa.me/96170579786" class="btn btn-primary btn-large" data-i18n="hero_cta1">Create Your Menu</a>
                        <a href="#restaurants" class="btn btn-secondary btn-large" data-i18n="hero_cta2">Browse Restaurants</a>
                    </div>
                </div>
                <div class="hero-visual">
                    <!-- Placeholder for phone scanning mockup -->
                    <div class="phone-mockup">
                        <div class="phone-screen">
                            <div class="mockup-header">
                                <img src="https://qr.algorexe.com/images/website_images/logo.png" alt="QREXE Logo" class="mockup-logo" onerror="this.style.display='none'">
                                <span class="mockup-logo-text">QREXE Menu</span>
                            </div>
                            <div class="mockup-body">
                                <div class="mockup-qr">
                                    <i class='bx bx-qr-scan'></i>
                                    <span>Scan to view Menu</span>
                                </div>
                                <div class="mockup-item"></div>
                                <div class="mockup-item short"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-bg-shape"></div>
        </section>

        <!-- How It Works Section -->
        <section class="how-it-works padding-block" id="how-it-works">
            <div class="container">
                <div class="section-header">
                    <h2 data-i18n="how_title">How It Works</h2>
                    <p data-i18n="how_subtitle">Get your digital menu up and running in three simple steps.</p>
                </div>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div class="step-icon"><i class='bx bx-list-plus'></i></div>
                        <h3 data-i18n="how_step1_title">Create Your Digital Menu</h3>
                        <p data-i18n="how_step1_desc">Sign up and easily add your categories, items, prices, and mouth-watering images.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div class="step-icon"><i class='bx bx-qr'></i></div>
                        <h3 data-i18n="how_step2_title">Generate Your QR Code</h3>
                        <p data-i18n="how_step2_desc">We automatically generate a custom QR code linked directly to your digital menu.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div class="step-icon"><i class='bx bx-mobile'></i></div>
                        <h3 data-i18n="how_step3_title">Customers Scan & View</h3>
                        <p data-i18n="how_step3_desc">Print the QR code on tables. Customers scan and browse the menu instantly—no app needed.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features padding-block bg-light" id="features">
            <div class="container">
                <div class="section-header">
                    <h2 data-i18n="feat_title">Powerful Features</h2>
                    <p data-i18n="feat_subtitle">Everything you need to provide a seamless dining experience.</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <i class='bx bx-mobile-alt'></i>
                        <h3 data-i18n="feat_1_t">Mobile Optimized</h3>
                        <p data-i18n="feat_1_d">Menus look perfect on any screen size, providing a smooth app-like experience for diners.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bx-refresh'></i>
                        <h3 data-i18n="feat_2_t">Instant Updates</h3>
                        <p data-i18n="feat_2_d">Change prices or add seasonal items instantly without reprinting physical menus.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bx-cloud-download'></i>
                        <h3 data-i18n="feat_3_t">No App Required</h3>
                        <p data-i18n="feat_3_d">Customers just point their phone camera at the QR code and the menu opens in their browser.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bxs-file-image'></i>
                        <h3 data-i18n="feat_4_t">QR Code Generation</h3>
                        <p data-i18n="feat_4_d">Download uncompromised, high-quality QR codes ready to be printed on stands or stickers.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bx-store-alt'></i>
                        <h3 data-i18n="feat_5_t">Versatile Use</h3>
                        <p data-i18n="feat_5_d">Perfect for restaurants, coffee shops, hotels, bars, and food trucks.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bx-tachometer'></i>
                        <h3 data-i18n="feat_6_t">Fast Loading</h3>
                        <p data-i18n="feat_6_d">Optimized for speed so customers can view your items immediately, even on slow connections.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bx-world'></i>
                        <h3 data-i18n="feat_7_t">Multi-Language Support</h3>
                        <p data-i18n="feat_7_d">Automatically display your menu in multiple languages to welcome international guests.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bx-palette'></i>
                        <h3 data-i18n="feat_8_t">Custom Branding</h3>
                        <p data-i18n="feat_8_d">Match your digital menu exactly to your restaurant’s unique colors and logo.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bx-bar-chart-alt-2'></i>
                        <h3 data-i18n="feat_9_t">Analytics & Insights</h3>
                        <p data-i18n="feat_9_d">Track which items are viewed the most and optimize your offerings based on real data.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bx-support'></i>
                        <h3 data-i18n="feat_10_t">24/7 Support</h3>
                        <p data-i18n="feat_10_d">Our dedicated team is always available to help you set up or troubleshoot your menu.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Restaurants Grid Section (Blade Target) -->
        {{-- <section class="restaurants padding-block" id="restaurants">
            <div class="container">
                <div class="section-header">
                    <h2 data-i18n="rest_title">Explore Restaurants & Coffee Shops</h2>
                    <p data-i18n="rest_subtitle">Join hundreds of modern businesses using QREXE digital menus.</p>
                </div>
                
                <div class="business-grid">
                    @foreach($business_list as $business)
                    <div class="business-card fadeIn">
                        <div class="business-image-wrapper">
                            <img src="{{ Storage::disk('public')->url($business->image) }}" alt="{{ $business->name }}" loading="lazy" class="business-image">
                            <span class="category-badge">{{ $business->category }}</span>
                        </div>
                        <div class="business-info">
                            <h3>{{ $business->name }}</h3>
                            <p class="slogan">{{ $business->slogan }}</p>
                            
                            <div class="stats">
                                <span class="stat-item"><i class='bx bx-food-menu'></i> <span data-i18n="rest_prod">{{ $business->products_count }} Products</span></span>
                                <span class="stat-item"><i class='bx bx-show'></i> <span data-i18n="rest_view">{{ $business->views_count }} Views</span></span>
                            </div>
                            
                            <a href="/menu/{{ $business->slug }}" class="view-menu-btn">
                                <span data-i18n="rest_btn">View Menu</span>
                                <i class='bx bx-right-arrow-alt dir-icon'></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section> --}}

        <!-- Benefits Section -->
        <section class="benefits padding-block bg-light" id="benefits">
            <div class="container">
                <div class="section-header">
                    <h2 data-i18n="ben_title">Benefits For Restaurant Owners</h2>
                    <p data-i18n="ben_subtitle">Why switching to a digital QR menu is a smart choice for your business.</p>
                </div>
                <div class="benefits-grid">
                    <!-- The rest of the benefits grid items below... (I will use JS for i18n text updates for simplicity or add attributes here) -->
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-money'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_1_t">Save Printing Costs</h4>
                            <p data-i18n="ben_1_d">Eliminate the recurring cost of designing and printing physical menus every time prices change.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-calendar-edit'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_2_t">Update Menus Anytime</h4>
                            <p data-i18n="ben_2_d">Mark items out of stock or update prices instantly right from your dashboard.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-shield-plus'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_3_t">Contactless Dining</h4>
                            <p data-i18n="ben_3_d">Provide a safe, hygienic experience while streamlining the ordering process.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-mobile-vibration'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_4_t">Mobile-First Experience</h4>
                            <p data-i18n="ben_4_d">Give your diners an intuitive, app-like scrolling and ordering experience on their phones.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bxs-camera'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_5_t">Showcase with Photos</h4>
                            <p data-i18n="ben_5_d">Beautiful imagery makes food sell itself. Display high-res photos for all your top dishes.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-stopwatch'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_6_t">Save Staff Time</h4>
                            <p data-i18n="ben_6_d">Guests decide what they want before the waiter arrives, increasing table turnover speeds.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-check-shield'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_7_t">Allergen & Diet Filters</h4>
                            <p data-i18n="ben_7_d">Let customers quickly filter to find vegan, gluten-free, or nut-free options stress-free.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bxs-coupon'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_8_t">Easy Promotions</h4>
                            <p data-i18n="ben_8_d">Push special daily offers and discounts to the top of the menu instantly.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-share-alt'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_9_t">Social Sharing</h4>
                            <p data-i18n="ben_9_d">Enable customers to easily share your menu links with their friends online.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bxs-flag-alt'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_10_t">Eco-Friendly Choice</h4>
                            <p data-i18n="ben_10_d">Significantly reduce paper waste and build a more sustainable business model.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-search-alt'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_11_t">SEO Benefits</h4>
                            <p data-i18n="ben_11_d">Having a published web app menu can improve your restaurant's visibility on Google.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class='bx bx-trending-up'></i></div>
                        <div class="benefit-text">
                            <h4 data-i18n="ben_12_t">Increase Engagement</h4>
                            <p data-i18n="ben_12_d">Incorporate appetizing images to increase visual appeal and boost average order value.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="cta-section" id="cta">
            <div class="container cta-container">
                <div class="cta-content">
                    <h2 data-i18n="cta_title">Start Your Digital Menu Today</h2>
                    <p data-i18n="cta_subtitle">Join QREXE and transform how your customers interact with your menu. Simple setup, zero hassle.</p>
                    <a href="https://wa.me/96170579786" class="btn btn-primary btn-large btn-light" data-i18n="cta_btn">Create Your Menu</a>
                </div>
                <div class="cta-decoration"></div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-container">
            <div class="footer-brand">
                <a href="/" class="brand-logo footer-logo">
                    <!-- Replace src with actual logo from backend or reference -->
                    <img src="https://qr.algorexe.com/images/website_images/logo.png" alt="QREXE Logo" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'30\'><text x=\'0\' y=\'20\' font-family=\'Inter\' font-weight=\'bold\' font-size=\'24\' fill=\'%23ffffff\'>QREXE</text></svg>'">
                </a>
                <p data-i18n="footer_desc">Digitize your restaurant with QREXE. Powerful digital menu tools for modern gastronomy.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class='bx bxl-facebook'></i></a>
                    <a href="#" aria-label="Instagram"><i class='bx bxl-instagram'></i></a>
                    <a href="#" aria-label="Twitter"><i class='bx bxl-twitter'></i></a>
                </div>
            </div>

            <div class="footer-links-group">
                <div class="footer-col">
                    <h4 data-i18n="foot_nav_plat">Platform</h4>
                    <ul>
                        <li><a href="#how-it-works" data-i18n="foot_nav_how">How It Works</a></li>
                        <li><a href="#features" data-i18n="foot_nav_feat">Features</a></li>
                        <li><a href="#restaurants" data-i18n="foot_nav_rest">Restaurants</a></li>
                        <li><a href="#benefits" data-i18n="foot_nav_ben">Benefits</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container footer-bottom">
            <p>&copy; 2026 QREXE, By ALGOREXE. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script >
        /* 
    QREXE Modern SaaS Landing Page
    Author: Antigravity
    Description: Vanilla JS for interactions and performance optimizations.
*/

document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.getElementById('main-nav');
    const navLinks = document.querySelectorAll('.nav-links a');

    if (mobileMenuToggle && mainNav) {
        mobileMenuToggle.addEventListener('click', () => {
            const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
            
            mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
            mainNav.classList.toggle('nav-active');
            
            // Toggle icon between Menu and X
            const icon = mobileMenuToggle.querySelector('i');
            if (icon) {
                if (!isExpanded) {
                    icon.classList.remove('bx-menu');
                    icon.classList.add('bx-x');
                } else {
                    icon.classList.remove('bx-x');
                    icon.classList.add('bx-menu');
                }
            }
        });
    }

    // Close mobile menu when clicking a link
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (mainNav.classList.contains('nav-active')) {
                mainNav.classList.remove('nav-active');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                const icon = mobileMenuToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('bx-x');
                    icon.classList.add('bx-menu');
                }
            }
        });
    });

    // 2. Sticky Navbar & Scroll Effects
    const navbar = document.getElementById('navbar');
    
    // Add shadow when scrolled
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Initial check in case loaded midway
    if (window.scrollY > 20) {
        navbar.classList.add('scrolled');
    }

    // 3. Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                // Adjust for fixed header offset
                const headerOffset = 80;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
  
                window.scrollTo({
                     top: offsetPosition,
                     behavior: "smooth"
                });
            }
        });
    });

    // 4. Subtle Intersection Observer Animations
    // Used to animate elements in when they scroll into view
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const fadeInObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Add staggered animation delay based on element's index if it's a grid item
                if (entry.target.classList.contains('step-card') || 
                    entry.target.classList.contains('feature-card') ||
                    entry.target.classList.contains('benefit-item')) {
                        // Assuming cards are already rendered via blade or DOM, this adds a basic fade class
                        entry.target.classList.add('fadeIn');
                }
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Select elements to animate
    const animatables = document.querySelectorAll('.step-card, .feature-card, .benefit-item');
    
    // Initially set opacity to 0 and apply transform via CSS or JS so they can fade in
    animatables.forEach((el, index) => {
        el.style.opacity = '0';
        // Add staggered delay
        el.style.animationDelay = `${index % 3 * 0.15}s`;
        fadeInObserver.observe(el);
    });

    // 5. Bilingual Support (EN & AR)
    const translations = {
        en: {
            title: "QREXE | Create Your Digital QR Menu",
            nav_how: "How It Works",
            nav_features: "Features",
            nav_restaurants: "Restaurants",
            nav_benefits: "Benefits",
            nav_login: "Login",
            nav_cta: "Create Menu",
            hero_badge: "Modernize Your Business",
            hero_title: "Create a Digital QR Menu for Your Restaurant",
            hero_subtitle: "Let customers scan your QR code and browse your menu instantly. Fast, completely contactless, and always up-to-date.",
            hero_cta1: "Create Your Menu",
            hero_cta2: "Browse Restaurants",
            how_title: "How It Works",
            how_subtitle: "Get your digital menu up and running in three simple steps.",
            how_step1_title: "Create Your Digital Menu",
            how_step1_desc: "Sign up and easily add your categories, items, prices, and mouth-watering images.",
            how_step2_title: "Generate Your QR Code",
            how_step2_desc: "We automatically generate a custom QR code linked directly to your digital menu.",
            how_step3_title: "Customers Scan & View",
            how_step3_desc: "Print the QR code on tables. Customers scan and browse the menu instantly—no app needed.",
            feat_title: "Powerful Features",
            feat_subtitle: "Everything you need to provide a seamless dining experience.",
            feat_1_t: "Mobile Optimized",
            feat_1_d: "Menus look perfect on any screen size, providing a smooth app-like experience for diners.",
            feat_2_t: "Instant Updates",
            feat_2_d: "Change prices or add seasonal items instantly without reprinting physical menus.",
            feat_3_t: "No App Required",
            feat_3_d: "Customers just point their phone camera at the QR code and the menu opens in their browser.",
            feat_4_t: "QR Code Generation",
            feat_4_d: "Download uncompromised, high-quality QR codes ready to be printed on stands or stickers.",
            feat_5_t: "Versatile Use",
            feat_5_d: "Perfect for restaurants, coffee shops, hotels, bars, and food trucks.",
            feat_6_t: "Fast Loading",
            feat_6_d: "Optimized for speed so customers can view your items immediately, even on slow connections.",
            feat_7_t: "Multi-Language Support",
            feat_7_d: "Automatically display your menu in multiple languages to welcome international guests.",
            feat_8_t: "Custom Branding",
            feat_8_d: "Match your digital menu exactly to your restaurant’s unique colors and logo.",
            feat_9_t: "Analytics & Insights",
            feat_9_d: "Track which items are viewed the most and optimize your offerings based on real data.",
            feat_10_t: "24/7 Support",
            feat_10_d: "Our dedicated team is always available to help you set up or troubleshoot your menu.",
            rest_title: "Explore Restaurants & Coffee Shops",
            rest_subtitle: "Join hundreds of modern businesses using QREXE digital menus.",
            rest_prod: "Products", /* Blade placeholder translation base text */
            rest_view: "Views",
            rest_btn: "View Menu",
            ben_title: "Benefits For Restaurant Owners",
            ben_subtitle: "Why switching to a digital QR menu is a smart choice for your business.",
            ben_1_t: "Save Printing Costs",
            ben_1_d: "Eliminate the recurring cost of designing and printing physical menus every time prices change.",
            ben_2_t: "Update Menus Anytime",
            ben_2_d: "Mark items out of stock or update prices instantly right from your dashboard.",
            ben_3_t: "Contactless Dining",
            ben_3_d: "Provide a safe, hygienic experience while streamlining the ordering process.",
            ben_4_t: "Mobile-First Experience",
            ben_4_d: "Give your diners an intuitive, app-like scrolling and ordering experience on their phones.",
            ben_5_t: "Showcase with Photos",
            ben_5_d: "Beautiful imagery makes food sell itself. Display high-res photos for all your top dishes.",
            ben_6_t: "Save Staff Time",
            ben_6_d: "Guests decide what they want before the waiter arrives, increasing table turnover speeds.",
            ben_7_t: "Allergen & Diet Filters",
            ben_7_d: "Let customers quickly filter to find vegan, gluten-free, or nut-free options stress-free.",
            ben_8_t: "Easy Promotions",
            ben_8_d: "Push special daily offers and discounts to the top of the menu instantly.",
            ben_9_t: "Social Sharing",
            ben_9_d: "Enable customers to easily share your menu links with their friends online.",
            ben_10_t: "Eco-Friendly Choice",
            ben_10_d: "Significantly reduce paper waste and build a more sustainable business model.",
            ben_11_t: "SEO Benefits",
            ben_11_d: "Having a published web app menu can improve your restaurant's visibility on Google.",
            ben_12_t: "Increase Engagement",
            ben_12_d: "Incorporate appetizing images to increase visual appeal and boost average order value.",
            cta_title: "Start Your Digital Menu Today",
            cta_subtitle: "Join QREXE and transform how your customers interact with your menu. Simple setup, zero hassle.",
            cta_btn: "Create Your Menu",
            footer_desc: "Digitize your restaurant with QREXE. Powerful digital menu tools for modern gastronomy.",
            foot_nav_plat: "Platform",
            foot_nav_how: "How It Works",
            foot_nav_feat: "Features",
            foot_nav_rest: "Restaurants",
            foot_nav_ben: "Benefits",
            foot_nav_supp: "Support",
            foot_nav_help: "Help Center",
            foot_nav_contact: "Contact Us",
            foot_nav_priv: "Privacy Policy",
            foot_nav_terms: "Terms & Conditions"
        },
        ar: {
            title: "كيو آر إكس | أنشئ قائمة طعامك الرقمية",
            nav_how: "كيف تعمل",
            nav_features: "المميزات",
            nav_restaurants: "المطاعم",
            nav_benefits: "الفوائد",
            nav_login: "تسجيل الدخول",
            nav_cta: "أنشئ قائمتك",
            hero_badge: "طوّر عملك",
            hero_title: "أنشئ قائمة طعام رقمية (QR) لمطعمك",
            hero_subtitle: "دع عملائك يمسحون رمز الاستجابة السريعة ويتصفحون قائمتك على الفور. سريع، آمن، ومحدّث دائماً.",
            hero_cta1: "أنشئ قائمتك",
            hero_cta2: "تصفح المطاعم",
            how_title: "كيف تعمل",
            how_subtitle: "احصل على قائمتك الرقمية بثلاث خطوات بسيطة.",
            how_step1_title: "أنشئ قائمتك الرقمية",
            how_step1_desc: "سجل بسهولة وأضف فئاتك، الأصناف، الأسعار، وصورك الشهية.",
            how_step2_title: "ولد رمز الـ QR الخاص بك",
            how_step2_desc: "نقوم تلقائياً بتوليد رمز استجابة سريعة مخصص يرتبط مباشرة بقائمتك.",
            how_step3_title: "العملاء يمسحون ويتصفحون",
            how_step3_desc: "اطبع الرمز على طاولاتك. سيقوم العملاء بمسح الرمز وتصفح القائمة فوراً—بدون تحميل أي تطبيق.",
            feat_title: "مميزات قوية",
            feat_subtitle: "كل ما تحتاجه لتقديم تجربة طعام سلسة.",
            feat_1_t: "محسّن للهاتف الموبايل",
            feat_1_d: "تظهر القوائم بشكل مثالي على جميع الشاشات، لتوفر تجربة تصفح رائعة للزبائن.",
            feat_2_t: "تحديثات فورية",
            feat_2_d: "يمكنك تغيير الأسعار أو إضافة أصناف موسمية فوراً دون الحاجة لإعادة طباعة القوائم.",
            feat_3_t: "بدون تحميل تطبيق",
            feat_3_d: "الزبائن ببساطة يوجهون كاميرا هاتفهم إلى الرمز وتفتح القائمة في متصفح الهاتف.",
            feat_4_t: "توليد أكواد QR",
            feat_4_d: "تحميل أكواد عالية الجودة وجاهزة للطباعة على الطاولات أو الملصقات.",
            feat_5_t: "استخدام شامل",
            feat_5_d: "مثالي للمطاعم، المقاهي، الفنادق، وعربات الطعام.",
            feat_6_t: "تحميل سريع",
            feat_6_d: "تم تحسين القوائم للسرعة ليتمكن العميل من التصفح فوراً، حتى مع الاتصال الضعيف.",
            feat_7_t: "دعم لغات متعددة",
            feat_7_d: "عرض قائمتك بلغات متعددة للترحيب بزوّارك الدوليين دون عناء.",
            feat_8_t: "هوية مخصصة",
            feat_8_d: "طابق قائمتك الرقمية بالضبط مع ألوان وشعار مطعمك المميز.",
            feat_9_t: "تحليلات وإحصائيات",
            feat_9_d: "تتبع الأصناف الأكثر مشاهدة وقم بتحسين عروضك بناءً على بيانات حقيقية.",
            feat_10_t: "دعم على مدار الساعة",
            feat_10_d: "فريقنا المتفاني متوفر دائماً لمساعدتك في إعداد قائمتك أو حل أي مشكلة.",
            rest_title: "استكشف المطاعم والمقاهي",
            rest_subtitle: "انضم إلى المئات من الأعمال العصرية التي تستخدم القوائم الرقمية من كيو آر إكس.",
            rest_prod: "منتجات", /* Adjust visually via blade if complex string replacement is needed */
            rest_view: "مشاهدة",
            rest_btn: "عرض القائمة",
            ben_title: "فوائد لأصحاب المطاعم",
            ben_subtitle: "لماذا يعد الانتقال إلى قائمة الـ QR الرقمية خيارًا ذكيًا لعملك.",
            ben_1_t: "توفير تكاليف الطباعة",
            ben_1_d: "تخلص من تكاليف تصميم وطباعة القوائم الورقية المستمرة كلما تغيرت أسعارك.",
            ben_2_t: "تحديث القوائم في أي وقت",
            ben_2_d: "علم الأصناف بنفاد الكمية أو غير أسعارك بأي لحظة مباشرة من لوحة التحكم.",
            ben_3_t: "تناول طعام دون تلامس",
            ben_3_d: "وفر تجربة آمنة وصحية مع تبسيط عملية الطلب لزبائنك.",
            ben_4_t: "تجربة الهاتف أولاً",
            ben_4_d: "امنح ضيوفك تجربة تصفح وطلب بديهية مثل التطبيقات على هواتفهم الذكية.",
            ben_5_t: "اعرض أطباقك بالصور",
            ben_5_d: "الصور الجميلة تروج الطعام. اعرض صوراً بدقة عالية لأطباقك المميزة.",
            ben_6_t: "توفير وقت طاقمك",
            ben_6_d: "يقرر الزبائن طلباتهم قبل وصول النادل، مما يزيد من سرعة تجهيز الطاولات.",
            ben_7_t: "فلاتر للحساسية والحميات",
            ben_7_d: "دع الزبائن يفلترون القائمة للعثور على خيارات خالية من الجلوتين، أو المكسرات، أو غيرها بسهولة.",
            ben_8_t: "عروض ترويجية سهلة",
            ben_8_d: "روج العروض اليومية الخاصة واعرض الخصومات في أعلى قائمتك فوراً.",
            ben_9_t: "مشاركة اجتماعية",
            ben_9_d: "مكن زبائنك من مشاركة روابط القائمة بسهولة مع أصدقائهم عبر الإنترنت.",
            ben_10_t: "خيار صديق للبيئة",
            ben_10_d: "قلل من هدر الورق بشكل ملحوظ وقم ببناء نموذج عمل أكثر استدامة.",
            ben_11_t: "تحسين محركات البحث",
            ben_11_d: "النشر كقائمة تطبيق ويب يزيد من ظهور مطعمك في بحث محرك جوجل.",
            ben_12_t: "زيادة التفاعل",
            ben_12_d: "إدراج صور شهية يزيد من الجاذبية البصرية للتصاميم ويرفع من متوسط قيمة الطلب.",
            cta_title: "ابدأ بتأسيس قائمتك الرقمية اليوم",
            cta_subtitle: "انضم إلى QREXE وقم بتغيير كيف يتفاعل عملاؤك مع قائمتك المذهلة. إعداد بسيط بدون تعقيد.",
            cta_btn: "أنشئ قائمتك",
            footer_desc: "حوّل مطعمك إلى الرقمية مع QREXE. أدوات قائمة رقمية قوية لفنون الطعام العصرية.",
            foot_nav_plat: "المنصة",
            foot_nav_how: "كيف تعمل",
            foot_nav_feat: "المميزات",
            foot_nav_rest: "المطاعم",
            foot_nav_ben: "الفوائد",
            foot_nav_supp: "الدعم",
            foot_nav_help: "مركز المساعدة",
            foot_nav_contact: "اتصل بنا",
            foot_nav_priv: "سياسة الخصوصية",
            foot_nav_terms: "الشروط والأحكام"
        }
    };

    const langToggleBtn = document.getElementById('lang-toggle');
    const langBtnText = langToggleBtn ? langToggleBtn.querySelector('.lang-text') : null;
    let currentLang = 'en';

    function setLanguage(lang) {
        currentLang = lang;
        document.documentElement.lang = lang;
        document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
        
        // Update button text
        if (langBtnText) {
            langBtnText.textContent = lang === 'ar' ? 'EN' : 'AR';
        }

        // Update all translation keys
        const transElements = document.querySelectorAll('[data-i18n]');
        transElements.forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) {
                if(el.tagName === 'TITLE'){
                    // If it's the document title tag
                    document.title = translations[lang][key];
                } else {
                    el.textContent = translations[lang][key];
                }
            }
        });
        
        // Handle Laravel Blade pseudo-translations fallback dynamically if needed 
        // Note: Dynamic generated content via blade won't auto translate without full frontend/backend hook.
        // We injected spans inside the Blade foreach for stats to allow partial trans.
    }

    if (langToggleBtn) {
        langToggleBtn.addEventListener('click', () => {
            const newLang = currentLang === 'en' ? 'ar' : 'en';
            setLanguage(newLang);
        });
    }
});

    </script>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/96170579786?text=Hello%20QREXE" class="whatsapp-button" target="_blank" rel="noopener noreferrer" aria-label="Contact us on WhatsApp">
        <i class='bx bxl-whatsapp'></i>
    </a>
</body>
</html>