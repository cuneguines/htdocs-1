import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import statsmodels.api as sm
# Import pandas
import pandas as pd

# Load your Excel data (replace 'your_data.xlsx' with your actual Excel file)
df = pd.read_excel('Planned_.xlsx', header=1)
print(df)
# Convert the date column to a datetime type
df['Date'] = pd.to_datetime(df['Due_Date'])

# Filter the DataFrame to include only rows with dates in 2023
df_2023 = df['2023']

# Plot the data for the year 2023
plt.figure(figsize=(12, 6))
plt.plot(df_2023['Labour Efficiency'])
plt.xlabel('Date')
plt.ylabel('Value')
plt.title('Time Series Data for 2023')
plt.show()