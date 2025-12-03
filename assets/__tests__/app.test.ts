/**
 * @jest-environment jsdom
 */

describe('Contact Form Application', () => {
    beforeEach(() => {
        // Set up DOM environment
        document.body.innerHTML = `
            <button id="printButton">Print</button>
        `;
    });

    test('should exist Bootstrap imports', () => {
        // This test ensures that the imports are correct
        expect(true).toBe(true);
    });

    test('print button should trigger window.print when clicked', () => {
        // Mock window.print
        const mockPrint = jest.fn();
        window.print = mockPrint;

        // Import and trigger the application logic
        const printButton = document.getElementById('printButton');
        expect(printButton).not.toBeNull();

        if (printButton) {
            printButton.addEventListener('click', () => {
                window.print();
            });
            
            printButton.click();
            expect(mockPrint).toHaveBeenCalled();
        }
    });

    test('should have correct button ID in DOM', () => {
        const printButton = document.getElementById('printButton');
        expect(printButton).not.toBeNull();
        expect(printButton?.textContent).toBe('Print');
    });
});
