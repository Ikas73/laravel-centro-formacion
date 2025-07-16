describe('Schedule Module: Single Occurrence Editing', () => {
  const eventTitle = 'Curso de Test para Cypress';
  const targetDaySelector = '.fc-day-wed';

  beforeEach(() => {
    cy.login('admin@admin.com', 'admin');
  });

  it('Drags and drops an event to a new day successfully', () => {
    cy.intercept('GET', '/admin/schedule/events*').as('getEvents');
    cy.intercept('POST', '/admin/schedules/*').as('updateSchedule');
    cy.visit('/admin/schedule');
    cy.wait('@getEvents');

    // CORRECTO: Encuentra el título y sube hasta el contenedor principal del evento.
    cy.get('.fc-event-title').contains(eventTitle).first().closest('.fc-event').as('eventToDrag');
    cy.get(targetDaySelector).first().as('dropTarget');
    cy.get('@eventToDrag').drag('@dropTarget', { force: true }); // Añadido force: true por si acaso.

    cy.get('#editConfirmationModal').should('be.visible');
    cy.get('#confirmEditSingle').click();
    cy.wait('@updateSchedule').its('response.statusCode').should('eq', 200);
    cy.wait('@getEvents');

    cy.get(targetDaySelector).find(`.fc-event-title:contains("${eventTitle}")`).should('exist');
    cy.get(`.fc-event-title:contains("${eventTitle}")`).should('have.length', 1);
  });

  it('Allows resizing the same event multiple times without conflict', () => {
    cy.intercept('GET', '/admin/schedule/events*').as('getEvents');
    cy.intercept('POST', '/admin/schedules/*').as('updateSchedule');
    cy.visit('/admin/schedule');
    cy.wait('@getEvents');

    // CORRECTO: Encuentra el título y sube hasta el contenedor principal del evento.
    cy.get('.fc-event-title').contains(eventTitle).first().closest('.fc-event').as('eventWrapper');

    // Primer redimensionamiento
    cy.get('@eventWrapper').find('.fc-event-resizer-end').trigger('mousedown', { which: 1 })
      .trigger('mousemove', { clientX: -50, clientY: 0 })
      .trigger('mouseup', { force: true });

    cy.get('#editConfirmationModal').should('be.visible').find('#confirmEditSingle').click();
    cy.wait('@updateSchedule').its('response.statusCode').should('eq', 200);
    cy.wait('@getEvents');

    // Segundo redimensionamiento
    cy.get('@eventWrapper').find('.fc-event-resizer-end').trigger('mousedown', { which: 1 })
      .trigger('mousemove', { clientX: 100, clientY: 0 })
      .trigger('mouseup', { force: true });

    cy.get('#editConfirmationModal').should('be.visible').find('#confirmEditSingle').click();
    cy.wait('@updateSchedule').its('response.statusCode').should('eq', 200);

    cy.get(`.fc-event-title:contains("${eventTitle}")`).should('exist');
  });
});