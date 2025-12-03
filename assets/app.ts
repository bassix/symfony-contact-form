/*
 * Welcome to your app's main TypeScript file!
 *
 * This file includes the Bootstrap 5 framework and custom styles.
 */

// Import Bootstrap 5 CSS
import 'bootstrap/dist/css/bootstrap.min.css';

// Import custom CSS
import './styles/app.css';

// Import Bootstrap JavaScript
import { Modal, Toast } from 'bootstrap';

// Initialize print button functionality
document.addEventListener('DOMContentLoaded', () => {
    const printButton = document.getElementById('printButton');
    if (printButton) {
        printButton.addEventListener('click', () => {
            window.print();
        });
    }
});

// Export for global usage if needed
export { Modal, Toast };
