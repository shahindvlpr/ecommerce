{{-- resources/views/layouts/partials/footer.blade.php --}}
<footer class="footer-premium">
    <div class="container">
        
        {{-- TOP SECTION --}}
        <div class="ft-top">
            {{-- Brand --}}
            <div class="ft-col-brand">
                <div class="ft-brand">
                    <i class="fas fa-crown me-2" style="color:#EF9F27"></i>Ekta<span>Mart</span>
                </div>
                <p class="ft-tagline">
                    Bangladesh's trusted multi-vendor marketplace. Quality products, fast delivery, secure payments.
                </p>
                <div class="ft-socials">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="ft-online mt-3">
                    <span class="ft-online-dot"></span> All systems operational
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <div class="ft-col-title">Quick links</div>
                <a href="{{ route('shop.index') }}" class="ft-link">Shop</a>
                <a href="{{ route('about') }}" class="ft-link">About us</a>
                <a href="{{ route('contact') }}" class="ft-link">Contact</a>
                <a href="{{ route('faq') }}" class="ft-link">FAQ</a>
                <a href="{{ route('terms') }}" class="ft-link">Terms & conditions</a>
                <a href="{{ route('privacy') }}" class="ft-link">Privacy policy</a>
            </div>

            {{-- Contact --}}
            <div>
                <div class="ft-col-title">Contact us</div>
                <div class="ft-contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>+880 1234 567890</span>
                </div>
                <div class="ft-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>support@ektamart.com</span>
                </div>
                <div class="ft-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Dhaka, Bangladesh</span>
                </div>
            </div>

            {{-- Newsletter --}}
            <div>
                <div class="ft-col-title">Newsletter</div>
                <p style="font-size:13px;color:#9896b0;margin-bottom:12px;line-height:1.6">
                    Subscribe to get exclusive deals and latest updates.
                </p>
                <div class="ft-newsletter-row">
                    <input type="email" class="ft-newsletter-input" placeholder="Your email address">
                    <button class="ft-newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- STATS ROW --}}
        <div class="ft-stats">
            <div class="ft-stat">
                <div class="ft-stat-num">50K+</div>
                <div class="ft-stat-label">Happy customers</div>
            </div>
            <div class="ft-stat">
                <div class="ft-stat-num">1,200+</div>
                <div class="ft-stat-label">Trusted vendors</div>
            </div>
            <div class="ft-stat">
                <div class="ft-stat-num">25K+</div>
                <div class="ft-stat-label">Products listed</div>
            </div>
            <div class="ft-stat">
                <div class="ft-stat-num">99.9%</div>
                <div class="ft-stat-label">Uptime</div>
            </div>
        </div>

        {{-- BOTTOM BAR --}}
        <div class="ft-bottom">
            <div class="ft-copy">
                &copy; {{ date('Y') }} <strong>EktaMart</strong> — Made with <span class="ft-heart">❤</span> in Bangladesh
            </div>
            <div class="ft-badges">
                <div class="ft-badge"><i class="fas fa-shield-alt"></i> SSL secured</div>
                <div class="ft-badge"><i class="fas fa-lock"></i> Safe checkout</div>
                <div class="ft-badge"><i class="fas fa-credit-card"></i> Multiple payments</div>
            </div>
        </div>

    </div>
</footer>

<style>
.footer-premium {
    background: #1a1730;
    color: #e2e0f0;
    padding: 2.5rem 0 0;
    margin-top: auto;
    border-top: 0.5px solid rgba(255,255,255,0.06);
}
.ft-top {
    display: grid;
    grid-template-columns: 1.4fr 1fr 1fr 1fr;
    gap: 2rem;
    padding-bottom: 2rem;
    border-bottom: 0.5px solid rgba(255,255,255,0.08);
}
.ft-brand {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
}
.ft-brand span { color: #AFA9EC; }
.ft-tagline {
    font-size: 13px;
    color: #9896b0;
    line-height: 1.7;
    margin-bottom: 1rem;
}
.ft-socials { display: flex; gap: 8px; }
.ft-socials a {
    width: 34px;
    height: 34px;
    border: 0.5px solid rgba(255,255,255,0.12);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #AFA9EC;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
}
.ft-socials a:hover {
    background: #534AB7;
    border-color: #534AB7;
    color: #EEEDFE;
    transform: translateY(-3px);
}
.ft-online {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(29,158,117,0.12);
    border: 0.5px solid rgba(29,158,117,0.25);
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 12px;
    color: #5DCAA5;
}
.ft-online-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #1D9E75;
    animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
    0%,100% { opacity: 1; }
    50% { opacity: .4; }
}
.ft-col-title {
    font-size: 11px;
    font-weight: 600;
    color: #AFA9EC;
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-bottom: .9rem;
}
.ft-link {
    display: block;
    font-size: 13px;
    color: #9896b0;
    text-decoration: none;
    padding: 4px 0;
    transition: color 0.2s, padding-left 0.2s;
}
.ft-link:hover {
    color: #CECBF6;
    padding-left: 4px;
}
.ft-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-bottom: 10px;
}
.ft-contact-item i {
    font-size: 13px;
    color: #7F77DD;
    margin-top: 2px;
    flex-shrink: 0;
}
.ft-contact-item span {
    font-size: 13px;
    color: #9896b0;
    line-height: 1.5;
}
.ft-newsletter-row {
    display: flex;
    gap: 6px;
}
.ft-newsletter-input {
    flex: 1;
    background: rgba(255,255,255,0.06);
    border: 0.5px solid rgba(255,255,255,0.12);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    color: #e2e0f0;
    outline: none;
}
.ft-newsletter-input::placeholder { color: #6b698a; }
.ft-newsletter-input:focus { border-color: #534AB7; }
.ft-newsletter-btn {
    background: #534AB7;
    border: none;
    border-radius: 8px;
    padding: 8px 14px;
    color: #EEEDFE;
    cursor: pointer;
    font-size: 13px;
    transition: background 0.2s;
}
.ft-newsletter-btn:hover { background: #3C3489; }
.ft-stats {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 1rem;
    padding: 1.5rem 0;
    border-bottom: 0.5px solid rgba(255,255,255,0.08);
}
.ft-stat { text-align: center; }
.ft-stat-num {
    font-size: 20px;
    font-weight: 700;
    color: #CECBF6;
}
.ft-stat-label {
    font-size: 12px;
    color: #6b698a;
    margin-top: 3px;
}
.ft-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 0;
    flex-wrap: wrap;
    gap: 10px;
}
.ft-copy {
    font-size: 12px;
    color: #6b698a;
}
.ft-copy strong { color: #9896b0; }
.ft-heart { color: #E24B4A; }
.ft-badges { display: flex; gap: 8px; flex-wrap: wrap; }
.ft-badge {
    display: flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,0.04);
    border: 0.5px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 11px;
    color: #9896b0;
}
.ft-badge i { color: #7F77DD; font-size: 12px; }

@media (max-width: 992px) {
    .ft-top { grid-template-columns: 1fr 1fr; }
    .ft-stats { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 576px) {
    .ft-top { grid-template-columns: 1fr; }
    .ft-stats { grid-template-columns: repeat(2,1fr); }
    .ft-bottom { flex-direction: column; text-align: center; }
}
</style>