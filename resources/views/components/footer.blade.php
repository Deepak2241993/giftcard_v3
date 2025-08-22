 <!-- <footer class="website-footer">
        <div class="footer-content text-center">
            <p>All Rights Reserved. © {{date('Y')}} FOREVER
                    MEDSPA Design By : <a href="https://www.forevermedspanj.com" target="_blank">TEMZ Solution Pvt.Ltd</a></p>
        </div>
    </footer> -->


    <footer class="website-footer">
    <div class="footer-content text-center">
        <p>
            All Rights Reserved. © {{date('Y')}} FOREVER MEDSPA 
            Design By : 
            <a href="https://www.forevermedspanj.com" target="_blank">
                TEMZ Solution Pvt.Ltd
            </a>
        </p>
    </div>
</footer>

<style>
/* Footer Styling */
.website-footer {
    background: #1a1a1a; /* dark background */
    color: #f1f1f1;     /* light text */
    padding: 20px 15px; /* padding all sides */
    margin-top: 30px;
    border-top: 3px solid #f39548; /* orange accent */
    font-family: Arial, sans-serif;
}

.website-footer .footer-content p {
    margin: 0;
    font-size: 14px;
    line-height: 1.6;
}

.website-footer .footer-content a {
    color: #f39548; /* orange link */
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.website-footer .footer-content a:hover {
    color: #ffffff; /* white on hover */
    text-decoration: underline;
}

@media (max-width: 768px) {
    .website-footer {
        padding: 15px 10px;
        font-size: 13px;
    }
}
</style>