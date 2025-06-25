import { register } from '@public-ui/components';
import { defineCustomElements } from '@public-ui/components/dist/loader';
import { DEFAULT } from '@public-ui/themes';
register(DEFAULT, defineCustomElements).catch(console.warn);