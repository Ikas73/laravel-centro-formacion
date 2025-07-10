describe('Schedule Module: Single Occurrence Editing', () => {
  const eventTitle = 'Re-engineered well-modulated leverage Gaming Manager';
  const targetDaySelector = '.fc-day-wed';

  beforeEach(() => {
    // Este bloque ahora solo hace el login. cy.session se encarga de la magia.
    cy.login('admin@admin.com', 'admin');
  });

  it('[BUG-REPRO] Fails by finding a ghost event after a single occurrence move', () => {
    // La visita y la intercepción se mueven DENTRO del test.
    cy.intercept('GET', '/admin/schedule/events').as('getEvents');
    cy.visit('/admin/schedule');
    cy.wait('@getEvents');

    // 1. Encuentra la primera ocurrencia del evento a arrastrar.
    cy.get('.fc-event-title').contains(eventTitle).first().as('eventToDrag');

    // 2. Encuentra la celda del día de destino.
    cy.get(targetDaySelector).first().as('dropTarget');

    // 3. Simula el Drag and Drop.
    cy.get('@eventToDrag').drag('@dropTarget');

    // 4. Confirma la edición "Solo este evento" en el modal.
    cy.get('#editConfirmationModal').should('be.visible');
    cy.get('#confirmEditSingle').click();
    
    // 5. Espera a que la operación termine y los eventos se recarguen.
    cy.wait('@getEvents');

    // 6. VERIFICACIÓN CRÍTICA: Cuenta cuántos eventos con ese título existen en TODO el calendario.
    //    Si el bug está resuelto, solo encontrará 1.
    cy.get('.fc-event-title:contains("' + eventTitle + '")').should('have.length', 1);
  });
});
