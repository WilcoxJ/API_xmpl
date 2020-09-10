SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[exchange_rate_USD](
	[id] [int] IDENTITY(1,1),
	[date_updated] [date] NULL,
	[uts_updated] [int] NULL,
	[currency] [varchar](5) NULL,
	[rate] [decimal](12, 6) NULL
) ON [PRIMARY]
GO
