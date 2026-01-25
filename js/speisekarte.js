/**
 * Ratsstuben Germering - Speisekarte Renderer
 * Dynamically loads and renders the menu from Speisekarte.json
 */

document.addEventListener('DOMContentLoaded', function() {
    const menuContainer = document.getElementById('dynamic-menu-container');
    if (!menuContainer) return;

    // Show loading state
    menuContainer.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-light" role="status"><span class="sr-only">Lade Speisekarte...</span></div></div>';

    fetch('../media/Speisekarte_v2.json')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            renderMenu(data, menuContainer);
        })
        .catch(error => {
            console.error('Error loading menu:', error);
            menuContainer.innerHTML = `
                <div class="alert alert-danger bg-dark text-white border-secondary text-center py-5">
                    <h4>Hoppla!</h4>
                    <p>Die Speisekarte konnte nicht geladen werden.</p>
                    <a href="../media/Speisekarte_RatsstubenGermering.pdf" class="btn btn-outline-light mt-3" download>PDF-Version herunterladen</a>
                </div>
            `;
        });
});

function renderMenu(data, container) {
    container.innerHTML = ''; // Clear loading state
    
    const wrapper = document.createElement('div');
    wrapper.className = 'menu-container shadow-lg mb-5';

    data.categories.forEach(category => {
        // Create section
        const section = document.createElement('section');
        section.className = 'menu-section';
        if (category.folded) {
            section.classList.add('collapsible');
        } else {
            section.classList.add('active'); // Always visible if not collapsible
        }
        
        // Category Title
        const title = document.createElement('h2');
        title.className = 'menu-category-title';
        title.textContent = category.name;
        
        if (category.folded) {
            title.addEventListener('click', () => {
                section.classList.toggle('active');
            });
        }
        
        section.appendChild(title);

        // Content Wrapper for Accordion
        const contentWrapper = document.createElement('div');
        contentWrapper.className = 'menu-content-wrapper';

        // Grid for items
        const grid = document.createElement('div');
        grid.className = 'menu-grid';

        category.items.forEach(item => {
            const itemEl = document.createElement('div');
            itemEl.className = 'menu-item';

            // Header (ID, Name, Dots, Price)
            const header = document.createElement('div');
            header.className = 'menu-item-header';

            const nameWrapper = document.createElement('div');
            nameWrapper.className = 'menu-item-name-wrapper';

            if (item.id) {
                const idSpan = document.createElement('span');
                idSpan.className = 'menu-item-id';
                idSpan.textContent = item.id;
                nameWrapper.appendChild(idSpan);
            }

            const nameH3 = document.createElement('h3');
            nameH3.className = 'menu-item-name';
            
            // Add size if exists (for drinks)
            let nameContent = item.name;
            if (item.size) {
                nameContent += ` <span class="menu-item-size">${item.size}</span>`;
            }
            
            // Add badge if exists
            if (item.badge) {
                const badgeClass = item.badge_type ? `badge-${item.badge_type}` : 'badge-classic';
                nameContent += ` <span class="menu-item-badge ${badgeClass}">${item.badge}</span>`;
            }
            
            nameH3.innerHTML = nameContent;
            nameWrapper.appendChild(nameH3);
            header.appendChild(nameWrapper);

            const dots = document.createElement('div');
            dots.className = 'menu-item-dots';
            header.appendChild(dots);

            const price = document.createElement('span');
            price.className = 'menu-item-price';
            price.textContent = formatPrice(item.price);
            header.appendChild(price);

            itemEl.appendChild(header);

            // Description
            if (item.description) {
                const desc = document.createElement('p');
                desc.className = 'menu-item-description';
                desc.textContent = item.description;
                itemEl.appendChild(desc);
            }

            grid.appendChild(itemEl);
        });

        contentWrapper.appendChild(grid);
        section.appendChild(contentWrapper);
        wrapper.appendChild(section);
    });

    // Footer note
    if (data.footer) {
        const footerNote = document.createElement('p');
        footerNote.className = 'menu-footer-note';
        footerNote.textContent = data.footer;
        wrapper.appendChild(footerNote);
    }

    container.appendChild(wrapper);
}

function formatPrice(price) {
    if (typeof price !== 'number') return price;
    return price.toLocaleString('de-DE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }) + ' €';
}
