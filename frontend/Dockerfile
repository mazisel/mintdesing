FROM node:18-alpine

WORKDIR /app

# Copy package files first for better caching
COPY package.json yarn.lock ./

# Install dependencies
RUN yarn install --frozen-lockfile

# Copy source code
COPY . .

# Build the application
RUN yarn build

# Expose port
EXPOSE 3005

# Serve the built application
CMD ["npx", "serve", "-s", "build", "-l", "3005"]
