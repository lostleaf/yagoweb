class Model
	words = File.read("query.txt").split(/\n\n+/).map{|x| x.split("\n")}
	@@descriptions, @@queries = words.inject([[],[]]) {|l, e| l[0]<<e[0];l[1]<<e[1];l}
	@@client = Mysql2::Client.new(
		:host => "211.80.57.220",   
		:username => "yago",   
		password: "2UejLBzC8hHcrZKd",  
		database: "yago"  
	)

	def self.descriptions
		@@descriptions
	end

	def self.query(type, arg)
		res = @@client.query(@@queries[type.to_i].gsub('?', @@client.escape(arg)), :as => :array)
		[res.fields, res.to_a]
	end
end