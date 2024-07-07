
describe('Adding form Data to IndexedDB', () => {

  it.skip('submit form data', () => {
    cy.visit('http://127.0.0.1:8000/web-form')

    cy.get('[data-cy="name"]').type('John Doe')
    cy.get('[data-cy="email"]').type('john.doe@example.com')
    cy.get('[data-cy="nic"]').type('920920458')

    cy.get('[data-cy="submit"]').click()

    // Check submited data shown in the data table
    cy.get('table').find('tr').last().within(() => {
      cy.get('td').eq(0).should('contain', 'John Doe');
      cy.get('td').eq(1).should('contain', 'john.doe@example.com');
      cy.get('td').eq(2).should('contain', '920920458');
    });
  })

  it('show error submitting a duplicate email', () => {
    cy.visit('http://127.0.0.1:8000/web-form')

    cy.get('[data-cy="name"]').type('John Doe')
    cy.get('[data-cy="email"]').type('john@example.com')
    cy.get('[data-cy="nic"]').type('920920454')

    cy.get('[data-cy="submit"]').click()

    //Submitting above details with duplicate email addresss.

    cy.get('[data-cy="name"]').type('John Doe')
    cy.get('[data-cy="email"]').type('john@example.com')
    cy.get('[data-cy="nic"]').type('920920454')

    cy.get('[data-cy="submit"]').click()

    cy.get('div.alert.alert-danger[role="alert"]').should('be.visible');
  })
})