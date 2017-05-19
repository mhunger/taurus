import { TaurissimoPage } from './app.po';

describe('taurissimo App', () => {
  let page: TaurissimoPage;

  beforeEach(() => {
    page = new TaurissimoPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
