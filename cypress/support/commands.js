// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************

Cypress.Commands.add('login', (email, password) => {
  cy.session([email, password], () => {
    cy.request({
      method: 'GET',
      url: '/login',
    }).then((response) => {
      const csrfToken = Cypress.$(response.body).find('input[name="_token"]').val();

      cy.request({
        method: 'POST',
        url: '/login',
        form: true,
        body: {
          _token: csrfToken,
          email: email,
          password: password,
        },
      });
    });
  });
});
